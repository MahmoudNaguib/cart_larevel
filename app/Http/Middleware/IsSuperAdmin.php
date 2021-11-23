<?php

namespace App\Http\Middleware;

use Closure;

class IsSuperAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth()->user()->role_id ==1) {
            return $next($request);
        }
        flash()->error(trans('app.You are not authorized to do this action'));
        return redirect('/');
    }

}
