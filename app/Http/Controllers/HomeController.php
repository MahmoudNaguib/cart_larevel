<?php

namespace App\Http\Controllers;



class HomeController extends Controller {
    public function index(){
        if(auth()->user()){
            return redirect(lang().'/admin/dashboard');
        }
        else{
            return redirect(lang().'/auth/login');
        }
    }
}
