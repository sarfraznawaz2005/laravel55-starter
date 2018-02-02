<?php

namespace Modules\Admin\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && user()->isSuperAdmin()) {
            return $next($request);
        }

        return redirect(route('admin_login'));
    }
}
