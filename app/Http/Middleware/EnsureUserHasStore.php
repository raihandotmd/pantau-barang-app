<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has a store
        if ($request->user() && !$request->user()->store_id) {
            return redirect()
                ->route('store.create')
                ->with('error', 'You need to create a store first to access this feature.');
        }

        return $next($request);
    }
}
