<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class Headers
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

        $response->headers->set('X-Frame-Options', 'DENY', true);
        $response->headers->set('X-Content-Type-Options', 'nosniff', true);
        $response->headers->set('X-Download-Options', 'noopen', true);
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none', true);
        $response->headers->set('X-XSS-Protection', '1; mode=block', true);
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains', true);
        //$response->headers->set('Content-Security-Policy', "default-src 'self'; img-src 'self'; style-src 'self' maxcdn.bootstrapcdn.com 'unsafe-inline'; font-src 'self' maxcdn.bootstrapcdn.com; script-src 'self' 'unsafe-inline'; connect-src 'self';", true);

        return $response;
    }
}
