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
            // You might want a dedicated rejected page, or just show an error
            abort(403, 'Maaf, pengajuan toko Anda ditolak. Silakan hubungi admin.');
        }

        // If status is active, ensure they are not trying to access the pending page
        if ($status === 'active' && $request->routeIs('store.pending')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
