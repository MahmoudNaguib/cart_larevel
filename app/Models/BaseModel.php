<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public $timestamps = false;

    public function getCountries() {
        return \App\Models\Country::pluck('title', 'id');
    }

    public function getAccountNameAttribute() {
        return @$this->getTranslation('name', lang()) . ' (' . @$this->currency->iso . ')';
    }

    public function getAddresses() {
        return \App\Models\Address::own()->get(['id','city', 'district', 'zip_code', 'address', 'title','notes'])->pluck('full_address', 'id');
    }


    public function getCurrencies() {
        return \App\Models\Currency::pluck('title', 'id');
    }

    public function getProducts() {
        return \App\Models\Product::pluck('title', 'id');
    }

    public function getUsers() {
        return \App\Models\User::pluck('name', 'id');
    }

    public function getSections() {
        return \App\Models\Section::active()->pluck('title', 'id');
    }

    public function getMainCategories() {
        return \App\Models\Category::active()->where('top_id',null)->pluck('title', 'id');
    }

    public function getCategoriesWithParents() {
        return \App\Models\Category::with(['top'])->active()->where('top_id', '!=', NULL)->get(['id', 'top_id', 'title'])->groupBy('top.title')
                        ->map(function ($item) {
                            return $item->pluck('title', 'id');
                        });
    }

}
