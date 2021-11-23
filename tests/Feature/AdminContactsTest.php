<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminContactsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list contacts");
        $this->actingAsAdmin();
        $this->get('en/admin/contacts')
                ->assertStatus(200);
    }

    public function test_view() {
        print("\n adminUser view contacts");
        $record = \App\Models\Contact::create(factory(\App\Models\Contact::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/contacts/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete contacts");
        $record = \App\Models\Contact::create(factory(\App\Models\Contact::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/contacts/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export contacts");
        $this->actingAsAdmin();
        $record = \App\Models\Contact::create(factory(\App\Models\Contact::class)->make()->toArray());
        $this->get('en/admin/contacts/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
