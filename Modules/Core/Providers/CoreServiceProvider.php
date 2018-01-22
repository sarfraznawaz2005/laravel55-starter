<?php

namespace Modules\Core\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Cleanup;
use Modules\Core\Http\Middleware\Headers;
use Modules\Core\Http\Middleware\HttpsProtocol;
use Modules\Core\Http\Middleware\XSSProtection;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @param Router $router
     * @param Kernel $kernel
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        #################################################
        // register our custom middlewares
        #################################################
        // route middlewares
        $router->middleware('XSSProtection', XSSProtection::class);
        // global middlewares
        $kernel->pushMiddleware(Headers::class);

        // creating problem with js scripts
        //$kernel->pushMiddleware(Minify::class);

        #################################################
        // register our commands
        #################################################
        $this->commands([Cleanup::class]);

        #################################################
        // enable/disable stuff on live vs local/staging
        #################################################
        if (config('app.env') === 'production') {

            // turn on https mode
            $kernel->pushMiddleware(HttpsProtocol::class);

            // disable query log
            queryLog(false);

            // disable debugbar
            config('debugbar.enabled', false);
            config('pretty-routes.url', '');
        }
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
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('core.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'core'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/core');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, \Config::get('view.paths')), [$sourcePath]), 'core');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'core');
        }
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
