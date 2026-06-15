<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // dd($request);
        if (Schema::hasTable('users')) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Check if the authenticated user is an admin
                if (Auth::user()->is_admin == 1) {
                    return $next($request); // Allow access to admin
                }
            }

            // If not authenticated or not an admin, redirect or return a 403 response
            return redirect('/')->with('error', 'You do not have access to the admin panel.');
        }
    }
}
