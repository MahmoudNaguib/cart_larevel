<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminMessagesTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list messages");
        $this->actingAsAdmin();
        $this->get('en/admin/messages')
                ->assertStatus(200);
    }

    public function test_view() {
        print("\n adminUser view messages");
        $record = \App\Models\Message::create(factory(\App\Models\Message::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/messages/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete messages");
        $record = \App\Models\Message::create(factory(\App\Models\Message::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/messages/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export messages");
        $this->actingAsAdmin();
        $record = \App\Models\Message::create(factory(\App\Models\Message::class)->make()->toArray());
        $this->get('en/admin/messages/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
