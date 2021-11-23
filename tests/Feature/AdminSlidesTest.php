<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminSlidesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list slides");
        $this->actingAsAdmin();
        $this->get('en/admin/slides')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create slides");
        $this->actingAsAdmin();
        $this->get('en/admin/slides/create')
                ->assertStatus(200)
                ->assertSee('slides');
    }

    public function test_post_create() {
        print("\n adminUser post create slides");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Slide::class)->make();
        $this->post('en/admin/slides/create', $factory->toArray());
        $latest = \App\Models\Slide::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit slides");
        $record = \App\Models\Slide::create(factory(\App\Models\Slide::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/slides/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit slides");
        $record = \App\Models\Slide::create(factory(\App\Models\Slide::class)->make()->toArray());
        $factory = factory(\App\Models\Slide::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/slides/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Slide::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view slides");
        $record = \App\Models\Slide::create(factory(\App\Models\Slide::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/slides/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete slides");
        $record = \App\Models\Slide::create(factory(\App\Models\Slide::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/slides/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export slides");
        $this->actingAsAdmin();
        $record = \App\Models\Slide::create(factory(\App\Models\Slide::class)->make()->toArray());
        $this->get('en/admin/slides/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
