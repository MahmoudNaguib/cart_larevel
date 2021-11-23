<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

class DashBoardController extends \App\Http\Controllers\Controller {

    public function __construct() {
        $this->module = 'dashboard';
        $this->Product=new \App\Models\Product;
        $this->Post=new \App\Models\Post;
        $this->User=new \App\Models\User;
        $this->Message=new \App\Models\Message;
    }

    public function getIndex() {
        $section = new \App\Models\Section();
        $data['page_title'] = trans('app.Dashboard');
        $data['total_products'] = \App\Models\Product::count();
        $data['total_orders'] = \App\Models\Order::count();
        $data['total_posts'] = \App\Models\Post::count();
        $data['total_users'] = \App\Models\User::where('id','>','1')->count();
        $data['products'] = $this->Product->includes()->latest()->limit(5)->get();
        $data['posts'] =$this->Post->includes()->latest()->limit(5)->get();
        $data['users'] = $this->User->includes()->where('id','>','1')->latest()->limit(5)->get();
        $data['messages'] =$this->Message->latest()->limit(5)->get();
        return view('admin.' . $this->module . '.index', $data);
    }

}
