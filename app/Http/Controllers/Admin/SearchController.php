<?php

namespace App\Http\Controllers\Admin;

class SearchController extends \App\Http\Controllers\Controller {

    public function __construct() {
        $this->module = 'search';
        $this->title = trans('app.Search results');
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = $this->title;
        if (request('q')) {
            $data['products'] = \App\Models\Product::search(trim(request('q')))->get();
            $data['posts'] = \App\Models\Post::search(trim(request('q')))->get();
            $data['users'] = \App\Models\User::search(trim(request('q')))->get();
        }
        return view('admin.' . $this->module . '.index', $data);
    }

}
