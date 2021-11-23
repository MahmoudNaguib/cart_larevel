<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminCountriesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list countries");
        $this->actingAsAdmin();
        $this->get('en/admin/countries')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create countries");
        $this->actingAsAdmin();
        $this->get('en/admin/countries/create')
                ->assertStatus(200)
                ->assertSee('countries');
    }

    public function test_post_create() {
        print("\n adminUser post create countries");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Country::class)->make();
        $this->post('en/admin/countries/create', $factory->toArray());
        $latest = \App\Models\Country::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit countries");
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/countries/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit countries");
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $factory = factory(\App\Models\Country::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/countries/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Country::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view countries");
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/countries/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete countries");
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/countries/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export countries");
        $this->actingAsAdmin();
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $this->get('en/admin/countries/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
