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
        if (session('role') == 2 || session('role') == 1) {
            return redirect()->route('dashboard');
            exit;
        }
        
        return $next($request);
    }
}
