<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 10/16/2016
 * Time: 2:11 PM
 */

namespace Modules\Core\Console;

use Artisan;
use File;

class Cleanup extends CoreCommand
{
    protected $signature = 'app:cleanup';
    protected $description = 'Cleans useless data and cache files.';

    // log finish message
    protected $logCompletion = true;

    public function handle()
    {
        $this->cleanClockworkDir();
        $this->cleanModuleViews();
        $this->deleteCache();
    }

    protected function cleanClockworkDir()
    {
        File::cleanDirectory(storage_path('clockwork'));

        // re-create .gitignore file
        @file_put_contents(storage_path('clockwork') . '/.gitignore', '*.json');
    }

    protected function cleanModuleViews()
    {
        File::cleanDirectory(base_path('resources/views/modules'));
    }

    protected function deleteCache()
    {
        Artisan::call('clear-compiled');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize');

        // clean cache folder
        File::cleanDirectory(storage_path('framework/cache'));
        // re-create .gitignore file
        @file_put_contents(storage_path('framework/cache') . '/.gitignore', '*' . "\n" . '!.gitignore');

        // clean minify plugin cache folders
        File::cleanDirectory(public_path('storage/cache/js'));
        File::cleanDirectory(public_path('storage/cache/css'));

        File::cleanDirectory(storage_path('email-previews'));
        File::cleanDirectory(storage_path('debugbar'));
    }
}
