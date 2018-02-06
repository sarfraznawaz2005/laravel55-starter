<?php

namespace Modules\Core\Http\Middleware;

use Auth;
use Cache;
use Closure;

class Cached
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
        $response = $next($request);
        $key = $request->fullUrl();

        // so that each user gets their own cached version
        if (Auth::check()) {
            $key .= Auth::user()->getAuthIdentifier();
        }

        if (Cache::has($key)) {
            $content = Cache::get($key);
            return response($content);
        }

        Cache::forever($key, $response->getContent());

        return $response;
    }
}
