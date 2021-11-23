<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Feature\DefaultData;

class AdminProductsTest extends TestCase {

    use RefreshDatabase,
        DefaultData;

    public function test_list() {
        print("\n adminUser list products");
        $this->actingAsAdmin();
        $this->get('en/admin/products')
                ->assertStatus(200);
    }

    public function test_get_create() {
        print("\n adminUser get create products");
        $this->actingAsAdmin();
        $this->get('en/admin/products/create')
                ->assertStatus(200)
                ->assertSee('products');
    }

    public function test_post_create() {
        print("\n adminUser post create products");
        $this->actingAsAdmin();
        $factory = factory(\App\Models\Product::class)->make();
        $this->post('en/admin/products/create', $factory->toArray());
        $latest = \App\Models\Product::orderBy('id', 'desc')->first();
        $this->assertEquals($factory->title, $latest->title);
        $latest->forceDelete();
    }

    public function test_get_edit() {
        print("\n adminUser get edit products");
        $record = \App\Models\Product::create(factory(\App\Models\Product::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/products/edit/' . $record->id)
                ->assertStatus(200)
                ->assertSee($record->title);
    }

    public function test_post_edit() {
        print("\n adminUser post edit products");
        $record = \App\Models\Product::create(factory(\App\Models\Product::class)->make()->toArray());
        $factory = factory(\App\Models\Product::class)->make();
        $this->actingAsAdmin();
        $this->post('en/admin/products/edit/' . $record->id, $factory->toArray());
        $record = \App\Models\Product::find($record->id);
        $this->assertEquals($record->title, $factory->title);
        $record->forceDelete();
    }

    public function test_view() {
        print("\n adminUser view products");
        $record = \App\Models\Product::create(factory(\App\Models\Product::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/products/view/' . $record->id)
                ->assertStatus(200)
                ->assertSeeText($record->title);
        $record->forceDelete();
    }

    public function test_delete_edit() {
        print("\n adminUser get delete products");
        $record = \App\Models\Product::create(factory(\App\Models\Product::class)->make()->toArray());
        $this->actingAsAdmin();
        $this->get('en/admin/products/delete/' . $record->id)
                ->assertStatus(302);
        $record->forceDelete();
    }

    public function test_export() {
        print("\n adminUser export products");
        $this->actingAsAdmin();
        $record = \App\Models\Product::create(factory(\App\Models\Product::class)->make()->toArray());
        $this->get('en/admin/products/export')
                ->assertStatus(200);
        $record->forceDelete();
    }

}
