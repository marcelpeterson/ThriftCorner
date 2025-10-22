<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please log in to continue.');
        }

        // Check if user's email is verified
        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')
                ->with('verification_required', 'Please verify your email address to create listings and contact sellers.');
        }

        return $next($request);
    }
}