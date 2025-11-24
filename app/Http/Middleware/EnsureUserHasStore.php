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
        $user = $request->user();
        
        // Skip check for Super Admins
        if ($user && $user->is_super_admin) {
            return $next($request);
        }
        
        // Check if user is authenticated and has a store
        if ($user && !$user->store_id) {
            return redirect()
                ->route('store.create')
                ->with('error', 'You need to create a store first to access this feature.');
        }

        return $next($request);
    }
}
