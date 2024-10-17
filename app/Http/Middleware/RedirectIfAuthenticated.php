<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
<<<<<<< HEAD

        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }
        else if (Auth::guard('kasir')->check()) {
=======
        if( Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        else if (Auth::guard('kasir')->check()){
>>>>>>> bb229261cb0043ec91dde3b7af9e2563ada5edaf
            return redirect('/kasir');
        }
        return $next($request);
    }
}