<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminPostsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list posts");
        $this->actingAsAdmin();
        $this->get('en/admin/posts')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create posts");
        $this->actingAsAdmin();
        $this->get('en/admin/posts/create')
                ->assertStatus(200)
                ->assertSee('posts');
    }

    public function test_post_create() {
        print("\n adminUser post create posts");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Post::class)->make();
        $this->post('en/admin/posts/create', $factory->toArray());
        $latest = \App\Models\Post::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit posts");
        $record = \App\Models\Post::create(factory(\App\Models\Post::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/posts/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit posts");
        $record = \App\Models\Post::create(factory(\App\Models\Post::class)->make()->toArray());
        $factory = factory(\App\Models\Post::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/posts/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Post::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view posts");
        $record = \App\Models\Post::create(factory(\App\Models\Post::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/posts/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete posts");
        $record = \App\Models\Post::create(factory(\App\Models\Post::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/posts/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export posts");
        $this->actingAsAdmin();
        $record = \App\Models\Post::create(factory(\App\Models\Post::class)->make()->toArray());
        $this->get('en/admin/posts/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
