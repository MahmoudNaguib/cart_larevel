<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminNotificationsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list notifications");
        $this->actingAsAdmin();
        $this->get('en/notifications')
                ->assertStatus(200);
    }

    public function test_view() {
        print("\n adminUser view notifications");
        $record = \App\Models\Notification::create(factory(\App\Models\Notification::class)->make(['user_id'=>$this->adminUser])->toArray());
        $this->actingAsAdmin();
        $this->get('en/notifications/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete notifications");
        $record = \App\Models\Notification::create(factory(\App\Models\Notification::class)->make(['user_id'=>$this->adminUser])->toArray());
        $this->actingAsAdmin();
        $this->get('en/notifications/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export notifications");
        $this->actingAsAdmin();
        $record = \App\Models\Notification::create(factory(\App\Models\Notification::class)->make(['user_id'=>$this->adminUser])->toArray());
        $this->get('en/notifications/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
