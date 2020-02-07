<?php

namespace System\Core\Commands;

use Illuminate\Console\Command;
use File, Str;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\MountManager;

class CreateModule extends Command
{
    /**
     * Module name
     *
     * @var [string]
     */
    protected $module;

    /**
     * Folder location of module
     *
     * @var [string]
     */
    protected $location;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module {name : Ten module can tao}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lenh tao mot module moi';

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
        /**
         * Check format name of module
         */
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Ten module khong hop le');
            return false;
        }

        /**
         * Init data to variables: module, location
         */
        $this->module = ucfirst($this->argument('name'));
        $this->location = base_path('modules' . DIRECTORY_SEPARATOR . $this->module);

        /**
         * Check existed module
         */
        if (File::isDirectory($this->location)) {
            $this->error('Module [' . $this->module . '] da ton tai.');
            return false;
        }

        /**
         * Copy construct module to modules/<module_name>
         */
        $this->publishStubs();
        /**
         * Rename all file to correct format
         */
        $this->renameModelsAndRepositories($this->location);
        /**
         * Search in all file and replace
         */
        $this->searchAndReplaceInFiles();
        /**
         * Created module successful.
         */
        $this->line('Da tao xong module: "' . $this->module . '"');
        return true;
    }

    public function searchAndReplaceInFiles()
    {
        $manager = new MountManager([
            'directory' => new Flysystem(new LocalAdapter($this->location)),
        ]);

        foreach ($manager->listContents('directory://', true) as $file) {
            if ($file['type'] === 'file') {
                $content = str_replace(
                    [
                        '{module}',
                        '{modules}',
                        '{Module}',
                        '{Modules}',
                    ],
                    [
                        strtolower($this->module),
                        strtolower($this->module) . 's',
                        ucfirst(Str::camel($this->module)),
                        ucfirst(Str::camel($this->module)) . 's',
                    ],
                    $manager->read('directory://' . $file['path'])
                );
                $manager->put('directory://' . $file['path'], $content);
            }
        }
    }

    public function renameModelsAndRepositories($location)
    {
        $paths = cms_scan_folder($location);
        if (empty($paths)) {
            return false;
        }
        foreach ($paths as $path) {
            $path = $location . DIRECTORY_SEPARATOR . $path; // path/to/{Module}.stub
            $newPath = $this->transformFilename($path); // path/to/Demo.php
            rename($path, $newPath);
            $this->renameModelsAndRepositories($newPath);
        }
        return true;
    }

    public function transformFilename($path)
    {
        return str_replace(
            [
                '{module}', // 0
                '{modules}',
                '{Module}',
                '{Modules}',
                '.stub'
            ],
            [
                strtolower($this->module), // 0
                strtolower($this->module) . 's',
                ucfirst(Str::camel($this->module)),
                ucfirst(Str::camel($this->module)) . 's',
                '.php'
            ],
            $path
        );
    }

    protected function publishStubs()
    {
        $from = base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'Module');

        if (File::isDirectory($from)) {
            $this->publishDirectory($from, $this->location);
        } else {
            $this->error('Can’t locate path: <' . $from . '>');
        }
    }

    protected function publishDirectory($from, $to)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]);

        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (!$manager->has('to://' . $file['path']))) {
                $manager->put('to://' . $file['path'], $manager->read('from://' . $file['path']));
            }
        }
    }
}