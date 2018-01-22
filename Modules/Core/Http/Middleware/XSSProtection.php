<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class XSSProtection
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
        if (!$request->has('nxx')) {
            $input = $request->all();

            array_walk_recursive($input, function (&$input) {
                $input = clean($input);
            });

            $request->merge($input);
        }

        return $next($request);
    }
}
