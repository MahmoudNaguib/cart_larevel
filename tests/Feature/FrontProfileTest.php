<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class FrontProfileTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_get_edit() {
        print("\n front get edit");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAs($record);
        $this->get('en/profile/edit')
                ->assertStatus(200)
                ->assertSee('edit');
    }

    public function test_post_edit() {
        print("\n front get edit");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAs($record);
        $factory = factory(\App\Models\User::class)->make();
        $response = $this->post('en/profile/edit', $factory->toArray())
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
        $record = \App\Models\User::find($record->id);
        $this->assertEquals($record->name, $factory->name);
    }

    public function test_get_change_password() {
        print("\n front get change-password");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAs($record);
        $this->get('en/profile/change-password')
                ->assertStatus(200)
                ->assertSee('change');
    }

    public function test_post_change_password() {
        print("\n front get change-password");
        $tenant = (app()->environment() == 'testing') ? 'demo' : tenant();
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray() + ['password' => $tenant . '@12345']);
        $this->actingAs($record);
        $this->post('en/profile/change-password', ['old_password' => 'demo@12345', 'password' => 'demo@12345', 'password_confirmation' => 'demo@12345'])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
    }

    public function test_get_logout() {
        print("\n front get logout");
        $record = \App\Models\User::create(factory(\App\Models\User::class)->make()->toArray());
        $this->actingAs($record);
        $this->get('en/profile/logout')
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
    }
}
