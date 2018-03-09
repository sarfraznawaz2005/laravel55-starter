<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class LogEnhancer extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $logger = \Log::getMonolog();

        // Additional info in message
        $logger->pushProcessor(function ($record) {
            $info = '';

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $info .= 'IP: ' . $_SERVER['REMOTE_ADDR'];
            }

            if (isset($_SERVER['REQUEST_URI'])) {
                $info .= "\n" . $_SERVER['REQUEST_METHOD'] . " " . url($_SERVER['REQUEST_URI']);
            }

            if (isset($_SERVER['HTTP_REFERER'])) {
                $info .= "\nReferer: " . $_SERVER['HTTP_REFERER'];
            }

            if (\Auth::check()) {
                $info .= "\n" . 'User:' . \Auth::user()->id . ' (' . \Auth::user()->email . ')';
            }

            if ($info) {
                $dots = str_repeat('=', 50);

                $info = "\n$dots\n$info\n$dots";

                if (strpos($record['message'], "\n")) {
                    $record['message'] = preg_replace("/\n/", $info . "\n", $record['message'], 1);
                } else {
                    $record['message'] .= $info . "\n";
                }
            }

            return $record;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
