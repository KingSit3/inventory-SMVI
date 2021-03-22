<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Login
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
         // Jika belum Login
        if (session('login') <> 1) {
            return redirect()->route('login')->with('gagal', 'Anda Belum Login');
            exit;
        }

        return $next($request);
    }
}
