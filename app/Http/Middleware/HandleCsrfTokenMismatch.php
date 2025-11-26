<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class HandleCsrfTokenMismatch
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch. Please refresh the page.',
                    'error' => 'token_mismatch'
                ], 419);
            }
            
            // For regular requests, redirect back with error message
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Sesi Anda telah berakhir. Silakan coba lagi.');
        }
    }
}