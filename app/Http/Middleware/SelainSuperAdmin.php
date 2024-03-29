<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SelainSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('role') != 0) {
            // return redirect()->route('dashboard');
            return abort('404');
            exit;
        }
        
        return $next($request);
    }
}
