<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/19/2017
 * Time: 1:57 PM
 */
namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // include all *.php files
        foreach (glob(base_path('Modules/Core/Resources/views/directives/*.php')) as $filename) {
            require_once($filename);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
