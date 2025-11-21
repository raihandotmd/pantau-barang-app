<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyStoreOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get route parameters
        $route = $request->route();
        $user = $request->user();

        if (!$user || !$user->store_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check store ownership for route model bindings
        $modelsToCheck = [
            'item' => \App\Models\Items::class,
            'category' => \App\Models\Categories::class,
            'stock_movement' => \App\Models\StockMovements::class,
            'stockMovement' => \App\Models\StockMovements::class,
        ];

        foreach ($modelsToCheck as $param => $modelClass) {
            $model = $route->parameter($param);
            
            if ($model instanceof $modelClass) {
                // Verify the model belongs to user's store
                if ($model->store_id !== $user->store_id) {
                    abort(403, 'This resource does not belong to your store.');
                }
            }
        }

        return $next($request);
    }
}
