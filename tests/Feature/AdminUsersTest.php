<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminUsersTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list users");
        $this->actingAsAdmin();
        $this->get('en/admin/users')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create users");
        $this->actingAsAdmin();
        $this->get('en/admin/users/create')
                ->assertStatus(200)
                ->assertSee('users');
    }

    public function test_post_create() {
        print("\n adminUser post create users");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\User::class)->make();
        $this->post('en/admin/users/create', $factory->toArray());
        $latest = \App\Models\User::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit users");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/users/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->name);
    }

    public function test_post_edit() {
        print("\n adminUser post edit users");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $factory = factory(\App\Models\User::class)->make();
        $this->actingAsAdmin();
        $response = $this->post('en/admin/users/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\User::find($record->id);
        $this->assertEquals($record->name, $factory->name);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view users");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/users/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->name);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete users");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/users/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export users");
        $this->actingAsAdmin();
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->get('en/admin/users/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
