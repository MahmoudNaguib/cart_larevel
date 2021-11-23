<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class FrontHomeTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_get_index() {
        print("\n front get home page");
        $this->get('en/')
                ->assertStatus(200);
    }

}
