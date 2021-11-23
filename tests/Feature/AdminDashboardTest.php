<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminDashboardTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_get_index() {
        print("\n adminUser get index dashboard");
        $this->actingAsAdmin();
        $this->get('en/admin/dashboard')
                ->assertStatus(200)
                ->assertSee('dashboard');
    }

}
