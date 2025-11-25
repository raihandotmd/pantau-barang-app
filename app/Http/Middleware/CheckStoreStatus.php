<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->store) {
            return $next($request);
        }

        $status = $user->store->status;

        if ($status === 'pending') {
            if ($request->routeIs('store.pending')) {
                return $next($request);
            }
            return redirect()->route('store.pending');
        }

        if ($status === 'rejected') {
            // Allow access to store profile edit/update routes so they can fix issues
            if ($request->routeIs('store-profile.edit') || $request->routeIs('store-profile.update') || $request->routeIs('store.rejected') || $request->is('logout')) {
                return $next($request);
            }
            return redirect()->route('store.rejected');
        }

        // If status is active, ensure they are not trying to access the pending or rejected page
        if ($status === 'active' && ($request->routeIs('store.pending') || $request->routeIs('store.rejected'))) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
