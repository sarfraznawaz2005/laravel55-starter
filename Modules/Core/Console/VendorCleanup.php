<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;

class VendorCleanup extends Command
{
    protected $signature = 'vendor:cleanup {--o : Verbose Output}';
    protected $description = 'Cleans up useless files from vendor folder.';

    // Default patterns for common files
    protected $patterns = [
        '.git',
        '.github',
        'test',
        'tests',
        'travis',
        'demo',
        'demos',
        'example*',
        'doc',
        'docs',
        'license',
        'changelog*',
        'contributing*',
        'history*',
        'upgrading*',
        'upgrade*',
        '.idea',
        '.vagrant',
        'readme*',
        '_ide_helper.php',
        '{,.}*.yml',
        '*.yaml',
        '*.md',
        '*.xml',
        '*.log',
        '*.txt',
        '*.json',
        '*.dist',
        '*.pdf',
        '*.xls',
        '*.doc',
        '*.docx',
        '*.png',
        '*.gif',
        '*.jpg',
        '*.bmp',
        '*.jpeg',
        '*.ico',
        '.php_cs*',
        '.scrutinizer',
        '.gitignore',
        '.gitattributes',
        '.editorconfig',
        'dockerfile',
        'composer.json',
        'composer.lock',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directories = $this->expandTree(base_path('vendor'));

        $isVerbose = $this->option('o');

        foreach ($directories as $directory) {
            foreach ($this->patterns as $pattern) {

                $casePattern = preg_replace_callback('/([a-z])/i', [$this, 'prepareWord'], $pattern);

                foreach (glob($directory . '/' . $casePattern, GLOB_BRACE) as $file) {

                    if (is_dir($file)) {

                        if ($isVerbose) {
                            echo ('DELETING DIR: ' . $file) . PHP_EOL;
                        }

                        $this->delTree($file);
                    } else {
                        if ($isVerbose) {
                            echo ('DELETING FILE: ' . $file) . PHP_EOL;
                        }

                        @unlink($file);
                    }
                }
            }
        }

        echo ('Vendor Cleanup Done!') . PHP_EOL;
    }

    /**
     * Recursively traverses the directory tree
     *
     * @param  string $dir
     * @return array
     */
    protected function expandTree($dir)
    {
        $directories = [];
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $directory = $dir . '/' . $file;

            if (is_dir($directory)) {
                $directories[] = $directory;
                $directories = array_merge($directories, $this->expandTree($directory));
            }
        }

        return $directories;
    }

    /**
     * Recursively deletes the directory
     *
     * @param  string $dir
     * @return bool
     */
    protected function delTree($dir)
    {
        if (!file_exists($dir) || !is_dir($dir)) {
            return false;
        }

        $iterator = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $filename => $fileInfo) {
            if ($fileInfo->isDir()) {
                @rmdir($filename);
            } else {
                @unlink($filename);
            }
        }

        @rmdir($dir);
    }

    /**
     * Prepare word
     *
     * @param  string $matches
     * @return string
     */
    protected function prepareWord($matches)
    {
        return '[' . strtolower($matches[1]) . strtoupper($matches[1]) . ']';
    }
}
