<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class ApiCountriesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n api list countries");
        $this->actingAsApi();
        $this->get('api/countries')
                ->assertStatus(200);
    }

    public function test_view() {
        print("\n api view countries");
        $record = \App\Models\Country::create(factory(\App\Models\Country::class)->make()->toArray());
        $this->actingAsApi();
        $this->get('api/countries/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }
}
