<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class MainController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct() {
    }

    public function index() {
        $rows['categories']=\App\Models\Category::getCategoriesWithTop();
        $rows['languages']=\App\Models\User::getLanguages();
        $rows['configs'] = \App\Models\Config::where('lang',lang())->orWhere('lang',NULL)->pluck('value','field');
        $rows['countries'] = \App\Models\Country::get(['id','title','iso'])->pluck('name', 'id');
        $rows['currencies'] = \App\Models\Currency::get(['id','title','iso'])->pluck('name', 'id');
        return response()->json(['data' => $rows], 200);
    }

}
