<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminRolesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list roles");
        $this->actingAsAdmin();
        $this->get('en/admin/roles')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create roles");
        $this->actingAsAdmin();
        $this->get('en/admin/roles/create')
                ->assertStatus(200)
                ->assertSee('roles');
    }

    public function test_post_create() {
        print("\n adminUser post create roles");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Role::class)->make();
        $this->post('en/admin/roles/create', $factory->toArray());
        $latest = \App\Models\Role::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit roles");
        $record = \App\Models\Role::create(factory(\App\Models\Role::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/roles/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit roles");
        $record = \App\Models\Role::create(factory(\App\Models\Role::class)->make()->toArray());
        $factory = factory(\App\Models\Role::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/roles/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Role::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view roles");
        $record = \App\Models\Role::create(factory(\App\Models\Role::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/roles/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete roles");
        $record = \App\Models\Role::create(factory(\App\Models\Role::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/roles/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export roles");
        $this->actingAsAdmin();
        $record = \App\Models\Role::create(factory(\App\Models\Role::class)->make()->toArray());
        $this->get('en/admin/roles/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
