<?php

namespace Modules\Core\Http\Middleware;


use Closure;

class HttpsProtocol
{

    public function handle($request, Closure $next)
    {
        $referer = $request->header('referer');

        if ($referer && (false === strpos($referer, '10.200.75.192'))) {
            //exit;
        }

        if (!$request->secure() && env('APP_ENV') === 'production') {
            //$request->setTrustedProxies([$request->getClientIp()]);
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}