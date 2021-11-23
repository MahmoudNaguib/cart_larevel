<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class ApiAdminAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $row = auth()->user();
        if(!$row->role_id){
            $message = trans('app.Unauthorized user');
            return response()->json(['message' => $message], 401);
        }
        \Auth::login($row);
        request()->headers->set('Authorization','Bearer '. $row->token);
        return $next($request);
    }

}
