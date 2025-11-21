<?php

namespace App\Traits;

use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an activity
     *
     * @param string $action
     * @param string|null $description
     * @return void
     */
    protected function logActivity(string $action, ?string $description = null): void
    {
        if (Auth::check() && Auth::user()->store_id) {
            ActivityLogs::create([
                'store_id' => Auth::user()->store_id,
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        }
    }
}
