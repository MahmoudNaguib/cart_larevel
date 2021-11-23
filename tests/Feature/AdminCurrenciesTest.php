<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminCurrenciesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list currencies");
        $this->actingAsAdmin();
        $this->get('en/admin/currencies')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create currencies");
        $this->actingAsAdmin();
        $this->get('en/admin/currencies/create')
                ->assertStatus(200)
                ->assertSee('currencies');
    }

    public function test_post_create() {
        print("\n adminUser post create currencies");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Currency::class)->make();
        $this->post('en/admin/currencies/create', $factory->toArray());
        $latest = \App\Models\Currency::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit currencies");
        $record = \App\Models\Currency::create(factory(\App\Models\Currency::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/currencies/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit currencies");
        $record = \App\Models\Currency::create(factory(\App\Models\Currency::class)->make()->toArray());
        $factory = factory(\App\Models\Currency::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/currencies/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Currency::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view currencies");
        $record = \App\Models\Currency::create(factory(\App\Models\Currency::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/currencies/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete currencies");
        $record = \App\Models\Currency::create(factory(\App\Models\Currency::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/currencies/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export currencies");
        $this->actingAsAdmin();
        $record = \App\Models\Currency::create(factory(\App\Models\Currency::class)->make()->toArray());
        $this->get('en/admin/currencies/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
