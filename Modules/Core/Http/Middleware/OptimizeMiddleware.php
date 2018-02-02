<?php

namespace Modules\Core\Http\Middleware;

use Closure;

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

            /////////////////////////////////////////////////////////
            // comment this line if any issue with things like JS
            /////////////////////////////////////////////////////////
            $buffer = $this->filterContent($buffer);

            $response->setContent($buffer);

            //enable GZip, too!
            ini_set('zlib.output_compression', 'On');

            return $response;
        }
    }

    /**
     * Filter the spaces in the DOM.
     *
     * @param $content
     *
     * @return mixed
     */
    protected function filterContent($content)
    {
        $search = [
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
        ];

        $replace = [
            '>',
            '<',
            '\\1',
        ];

        if (preg_match("/\<html/i", $content) == 1 && preg_match("/\<\/html\>/i", $content) == 1) {
            return preg_replace($search, $replace, $content);
        }

        return $content;
    }
}