<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserLog;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        // Run the request
        $response = $next($request);

        // Log user activity
        if (auth()->check()) {
            UserLog::create([
                'user_id' => auth()->id(),
                'log_time' => now(),
            ]);
        }

        return $response;
    }
}
