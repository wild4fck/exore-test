<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Manager {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (!$user = auth()->user() or !$user->isManager()) {
            abort(403);
        }
        return $next($request);
    }
}
