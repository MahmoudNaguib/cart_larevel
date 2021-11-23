<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminPagesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list pages");
        $this->actingAsAdmin();
        $this->get('en/admin/pages')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create pages");
        $this->actingAsAdmin();
        $this->get('en/admin/pages/create')
                ->assertStatus(200)
                ->assertSee('pages');
    }

    public function test_post_create() {
        print("\n adminUser post create pages");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Page::class)->make();
        $this->post('en/admin/pages/create', $factory->toArray());
        $latest = \App\Models\Page::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit pages");
        $record = \App\Models\Page::create(factory(\App\Models\Page::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/pages/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit pages");
        $record = \App\Models\Page::create(factory(\App\Models\Page::class)->make()->toArray());
        $factory = factory(\App\Models\Page::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/pages/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Page::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view pages");
        $record = \App\Models\Page::create(factory(\App\Models\Page::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/pages/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete pages");
        $record = \App\Models\Page::create(factory(\App\Models\Page::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/pages/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export pages");
        $this->actingAsAdmin();
        $record = \App\Models\Page::create(factory(\App\Models\Page::class)->make()->toArray());
        $this->get('en/admin/pages/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
