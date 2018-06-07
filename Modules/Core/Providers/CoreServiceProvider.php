<?php

namespace Modules\Core\Providers;

use Bepsvpt\SecureHeaders\SecureHeadersServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Cleanup;
use Modules\Core\Console\SocketServer;
use Modules\Core\Console\VendorCleanup;
use Modules\Core\Http\Middleware\HttpsProtocol;
use Modules\Core\Http\Middleware\OptimizeMiddleware;
use Modules\Core\Http\Middleware\XSSProtection;
use function config;

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
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        #################################################
        // register our custom middlewares
        #################################################

        // route middlewares
        $router->aliasMiddleware('XSSProtection', XSSProtection::class);

        if (config('core.settings.minify_html_response')) {
            $kernel->pushMiddleware(OptimizeMiddleware::class);
        }

        #################################################
        // register our commands
        #################################################
        $this->commands([
            Cleanup::class,
            VendorCleanup::class,
            SocketServer::class,
        ]);

        #################################################
        // enable/disable stuff on live vs local/staging
        #################################################
        if (config('app.env') === 'production') {

            // turn on https mode
            $kernel->pushMiddleware(HttpsProtocol::class);

            // setup secure headers
            $kernel->pushMiddleware(SecureHeadersServiceProvider::class);

            // disable query log
            queryLog(false);

            // disable debugbar
            config(['debugbar.enabled' => false]);
            config(['pretty-routes.url' => '']);
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
        $viewPath = resource_path('views/modules/core');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

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
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'core');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
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
