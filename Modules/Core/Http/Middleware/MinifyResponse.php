<?php

namespace Modules\Core\Http\Middleware;

use Closure;

/**
 * Class MinifyResponseMiddleware.
 */
class MinifyResponse
{
    /**
     * @var array
     */
    protected $search = [
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s',
    ];

    /**
     * @var array
     */
    protected $replace = [
        '>',
        '<',
        '\\1',
    ];

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

        $response->setContent(
            $this->filterContent($response->getContent())
        );

        return $response;
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
        if (preg_match("/\<html/i", $content) == 1 && preg_match("/\<\/html\>/i", $content) == 1) {
            return preg_replace($this->search, $this->replace, $content);
        }

        return $content;
    }
}