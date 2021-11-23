<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminConfigsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_get_edit() {
        print("\n adminUser get edit configs");
        $this->actingAsAdmin();
        $this->get('en/admin/configs/edit')
                ->assertStatus(200)
                ->assertSee('configs');
    }

    public function test_post_edit() {
        print("\n adminUser post edit configs");
        $record = \App\Models\Config::create(factory(\App\Models\Config::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->post('en/admin/configs/edit', [$record->field => 'updated'])
                ->assertStatus(302);
    }

}
