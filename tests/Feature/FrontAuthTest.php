<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class FrontAuthTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_get_login() {
        print("\n front get login");
        $this->get('en/auth/login')
                ->assertStatus(200)
                ->assertSee('login');
    }

    public function test_post_login() {
        print("\n front post login");
        $this->post('en/auth/login', ['email' => 'invalid@example.com', 'password' => 'demo@12345'])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'danger');
    }

    public function test_post_valid_login() {
        print("\n front post valid login");
        $response = $this->post('en/auth/login', ['email' => $this->adminUser->email, 'password' => 'demo@12345'])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
    }

    public function test_get_forgot() {
        print("\n front get forgot-password");
        $this->get('en/auth/forgot-password')
                ->assertStatus(200)
                ->assertSee('forgot');
    }

    public function test_post_forgot() {
        print("\n front post forgot-password");
        $this->post('en/auth/forgot-password', ['email' => 'test@example.com'])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'danger');
    }

    public function test_post_valid_forgot() {
        print("\n front post valid forgot-password");
        $response = $this->post('en/auth/forgot-password', ['email' => $this->adminUser->email])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
    }

    public function test_get_register() {
        print("\n front get register");
        $this->get('en/auth/register')
                ->assertStatus(200)
                ->assertSee('login');
    }

    public function test_post_register() {
        print("\n front post register");
        $factory = factory(\App\Models\User::class)->make();
        $this->post('en/auth/register', $factory->toArray()+['password'=>env('DEFAULT_ADMIN_PASSWORD','zaqwsxcde@12345'),'password_confirmation'=>env('DEFAULT_ADMIN_PASSWORD','zaqwsxcde@12345')])
                ->assertStatus(302)
                ->assertSessionHas('flash_notification.0.level', 'success');
    }
}
