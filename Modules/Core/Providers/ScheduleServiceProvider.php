<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/19/2017
 * Time: 1:57 PM
 */
namespace Modules\Core\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $logFile = '';

    protected function setup()
    {
        $this->logFile = storage_path() . '/cronlog.log';

        // just in case even though console script should not have problem
        ini_set('memory_limit', '-1');
        ini_set('max_input_time', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);

        // this speeds up things a bit
        DB::disableQueryLog();
    }

    public function boot()
    {
        $this->setup();

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            /*
            // Cleanup useless temp files and cache
            $schedule->command('app:cleanup')->weekly()->appendOutputTo($this->logFile);

            $schedule->command('command_entery_reminder')
                ->dailyAt('17:00')
                ->appendOutputTo($this->logFile);

            $schedule->command('command_entery_reminder')
                ->dailyAt('17:00')
                ->appendOutputTo($this->logFile);
            */

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
