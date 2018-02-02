<?php

namespace AgentsApp\Http\Middleware;

use Closure;

/**
 * Class MinifyResponseMiddleware.
 */
class OptimizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            return $response;
        } else {
            $buffer = $response->getContent();

            if (strpos($buffer, '<pre>') !== false) {
                $replace = array(
                    '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    "/<\?php/" => '<?php ',
                    "/\r/" => '',
                    "/>\n</" => '><',
                    "/>\s+\n</" => '><',
                    "/>\n\s+</" => '><',
                );
            } else {
                $replace = array(
                    '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    "/<\?php/" => '<?php ',
                    "/\n([\S])/" => '$1',
                    "/\r/" => '',
                    "/\n+/" => "\n",
                    "/\t/" => '',
                    "/ +/" => ' ',
                );
            }

            $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);
            $response->setContent($buffer);

            ini_set('zlib.output_compression', 'On'); //enable GZip, too!

            return $response;
        }
    }
}