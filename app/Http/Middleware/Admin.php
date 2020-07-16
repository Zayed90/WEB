<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && ((Auth::user()->status == 'Admin') || (Auth::user()->status == 'adminApp1') || (Auth::user()->status == 'adminApp2') || (Auth::user()->status == 'adminApp3'))) {
            return $next($request);
        }
        else {
            return redirect('/login');
        }
    }
}
