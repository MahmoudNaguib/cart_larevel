<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class ApiAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $row = auth()->user();
        if (!$row) {
            $token =token();
            $row = \App\Models\User::where('token', $token)->first();
            if (!$row) {
                $message = trans('app.Unauthorized user');
                return response()->json(['message' => $message], 401);
            }
        }
        if (!$row) {
            $message = trans('app.Unauthorized user');
            return response()->json(['message' => $message], 401);
        }
        if (!$row->is_active) {
            $message = trans('app.Unauthorized user');
            return response()->json(['message' => $message], 401);
        }
        if (!$row->confirmed) {
            $message = trans('app.This account is not confirmed') . ', ' . trans('app.Please check your email to confirm your account');
            return response()->json(['message' => $message], 401);
        }
        \Auth::login($row);
        request()->headers->set('Authorization','Bearer '. $row->token);
        return $next($request);
    }

}
