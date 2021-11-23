<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminSectionsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list sections");
        $this->actingAsAdmin();
        $this->get('en/admin/sections')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create sections");
        $this->actingAsAdmin();
        $this->get('en/admin/sections/create')
                ->assertStatus(200)
                ->assertSee('sections');
    }

    public function test_post_create() {
        print("\n adminUser post create sections");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Section::class)->make();
        $this->post('en/admin/sections/create', $factory->toArray());
        $latest = \App\Models\Section::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit sections");
        $record = \App\Models\Section::create(factory(\App\Models\Section::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/sections/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit sections");
        $record = \App\Models\Section::create(factory(\App\Models\Section::class)->make()->toArray());
        $factory = factory(\App\Models\Section::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/sections/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Section::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view sections");
        $record = \App\Models\Section::create(factory(\App\Models\Section::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/sections/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete sections");
        $record = \App\Models\Section::create(factory(\App\Models\Section::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/sections/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export sections");
        $this->actingAsAdmin();
        $record = \App\Models\Section::create(factory(\App\Models\Section::class)->make()->toArray());
        $this->get('en/admin/sections/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
