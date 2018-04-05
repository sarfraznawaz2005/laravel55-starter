<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Crud\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CoreController;
use Nwidart\Modules\Facades\Module;
use Meta;
use function title;

class CrudController extends CoreController
{
    protected $nonModuleCommands = [
        'make:widget'
    ];

    public function index()
    {
        title('Module Manager');

        return view('crud::pages.index');
    }

    /**
     * Create new module
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->runCommand('module:make', $request->get('name'));
    }

    public function publish()
    {
        File::cleanDirectory(base_path('public/modules'));

        File::cleanDirectory(base_path('database/migrations'));
        @file_put_contents(base_path('database/migrations') . '/.gitignore', '*');

        shell_exec($this->getArtisan() . 'vendor:publish --all');
        shell_exec($this->getArtisan() . 'module:publish-config --force');
        shell_exec($this->getArtisan() . 'module:publish-migration');
        shell_exec($this->getArtisan() . 'module:publish-translation');

        $this->optimize();

        return $this->runCommand('module:publish', null, 'Modules Published Successfully!');
    }

    protected function optimize()
    {
        shell_exec($this->getArtisan() . 'clear-compiled');
        shell_exec($this->getArtisan() . 'cache:clear');
        shell_exec($this->getArtisan() . 'view:clear');
        shell_exec($this->getArtisan() . 'config:clear');
        shell_exec($this->getArtisan() . 'optimize --force');
        shell_exec($this->getArtisan() . 'app:cleanup');
    }

    public function toggleStatus($moduleName)
    {
        if ($moduleName !== 'Core' && $moduleName !== 'Crud') {
            if (Module::has($moduleName)) {
                $module = Module::find($moduleName);

                if ($module) {
                    $status = 'Enabled';
                    $isEnabled = $module->isStatus(1);

                    if ($isEnabled) {
                        $status = 'Disabled';
                        $module->disable();
                    } else {
                        $module->enable();
                    }

                    flash("Module $status Successfully!", 'success');
                    return redirect()->back();
                }
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFile(Request $request)
    {
        $name = trim(ucwords($request->get('name')));
        $commandArgument = $name . ' ' . $request->get('module');

        return $this->runCommand($request->get('command'), $commandArgument);
    }

    public function destroy($moduleName)
    {
        if (Module::has($moduleName)) {
            if (!in_array($moduleName, Module::getSystemModules())) {
                $module = Module::find($moduleName);

                if ($module && $module->delete()) {
                    flash('Deleted Successfully!', 'success');
                    return redirect()->back();
                }
            }
        }

        return redirect()->back();
    }

    protected function getArtisan()
    {
        return 'php ' . base_path() . '/artisan ';
    }

    protected function returnBackWithError($error)
    {
        return redirect()->back()->withErrors([
            'error' => $error
        ]);
    }

    /**
     * @param $commandName
     * @param string $commandArgument
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function runCommand($commandName, $commandArgument = '', $message = '')
    {
        $moduleName = request()->get('module');
        $name = request()->get('name');

        if ($commandArgument) {
            $command = $this->getArtisan() . $commandName . ' ' . $commandArgument . ' 2>&1';
        } else {
            $command = $this->getArtisan() . $commandName . ' 2>&1';
        }

        if (in_array($commandName, $this->nonModuleCommands)) {
            $command = $this->getArtisan() . $commandName . ' ' . $name . ' 2>&1';
        }

        $result = shell_exec($command);

        if ($result) {
            if (in_array($commandName, $this->nonModuleCommands)) {
                if ($commandName === 'make:widget') {

                    if (file_exists(base_path('resources/views/widgets'))) {
                        rename(
                            base_path('resources/views/widgets'),
                            base_path('Modules/' . $moduleName . '/Resources/views/widgets')
                        );
                    }

                    if (file_exists(base_path('app/Widgets'))) {
                        if (
                        rename(
                            base_path('app/Widgets'),
                            base_path('Modules/' . $moduleName . '/Widgets')
                        )
                        ) {
                            $message = 'Widget created successfully!';
                        }
                    }

                }
            }

            flash($message ?: nl2br($result), $commandName === 'module:make' ? 'info' : 'success');

            if ($commandName === 'module:make') {
                shell_exec($this->getArtisan() . 'module:setup');
            }
        }

        //shell_exec($this->getArtisan() . 'config:cache');

        return redirect()->back();
    }

    /**
     * runs only new migrations
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrate()
    {
        $output = '';

        File::cleanDirectory(base_path('database/migrations'));
        @file_put_contents(base_path('database/migrations') . '/.gitignore', '*');
        shell_exec($this->getArtisan() . 'module:publish-migration');
        sleep(3);

        $dir = base_path() . '/database/migrations';
        $allFiles = glob($dir . '/*.php', GLOB_NOSORT);

        if ($allFiles) {
            $migrations = DB::table('migrations')->select('migration')->get()->pluck('migration')->toArray();

            if ($migrations) {
                foreach ($allFiles as $file) {
                    $fileName = pathinfo(basename($file))['filename'];

                    if (false !== in_array($fileName, $migrations)) {
                        @unlink($file);
                    }
                }
            }
        }

        $command = $this->getArtisan() . 'migrate --force';

        $output .= shell_exec($command . ' 2>&1');

        /*
        File::cleanDirectory(base_path('database/migrations'));
        @file_put_contents(base_path('database/migrations') . '/.gitignore', '*');
        shell_exec($this->getArtisan() . 'module:publish-migration');
        */

        flash($output ? nl2br($output) : 'Nothing to migrate.', 'warning');

        return redirect()->back();
    }
}
