<?php

namespace Permaxis\Laravel\CrudGenerator\App\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrudGeneratorCommand extends Command
{
    /**
     * php artisan permaxis:make:crudgenerator --m=\\Permaxis\\BoLogger\\App\\Entities\\Log --c=LogsController --ov --oc --rn=bologger --pk=bologger
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permaxis:make:crudgenerator
                           {--m= : The name of the model}
                           {--vd= : The sub directory of views to be created}
                           {--rn= : The route name prefix}
                           {--c= : The name of the controller}
                           {--cd= : The path of controller to be created}
                           {--oc : Override creation of controller}
                           {--bc : Bypass creation of controller}
                           {--ov : Override creation of views}
                           {--bv : Bypass creation of views}
                           {--sn= : Singular name of the entity (lower)}
                           {--pn= : Plural name of the entity (lower)}
                           {--pk= : Package name}
                           {--api= : Api enabled}
                           {--cmt=1 : Enable comment}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crud generator';


    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $fileSystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $fileSystem)
    {
        parent::__construct();

        $this->fileSystem = $fileSystem;
    }

    /**
     * Get the default path for the controllers directory.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getPathControllers()
    {
        return base_path().'/app/Http/Controllers';
    }

    /**
     * Get the default path for the resources directory.
     *
     * @return string
     */
    protected function getPathRessources()
    {
        return base_path().'/resources';
    }

    /**
     * Get the default path for the views directory.
     *
     * @return string
     */
    protected function getPathViews()
    {
        return $this->getPathRessources().'/views';
    }

    /**
     * Get the default root namespace for app.
     *
     * @return string
     */
    protected function getRootAppNamespace()
    {
        return 'App';
    }

    /**
     * Get the default root namespace for app.
     *
     * @return string
     */
    protected function getRootNamespaceController()
    {
        return $this->getRootAppNamespace()."\Http\Controllers";
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = $this->option('m');
        $controller = $this->option('c');

        if (empty($model))
        {
            $this->error('Model class not specified ! : --m=[modelClass]');
            exit(0);
        }

        if (empty($controller))
        {
            $this->error('Controller class not specified ! : --c=[controllerClass]');
            exit(0);
        }

        $controllerDir = $this->option('cd');
        $subViewsDir = $this->option('vd');
        $routeNamePrefix = $this->option('rn');
        $overrideController = $this->option('oc');
        $byPassController = $this->option('bc');
        $overrideViews = $this->option('ov');
        $byPassViews = $this->option('bv');
        $pluralEntityName =  $this->option('pn');
        $packageName = $this->option('pk');
        $enabledApi = $this->option('api');
        $enabledComment = $this->option('cmt');

        if (!empty($enabledApi) && $enabledApi == 1)
        {
            $controllerSourceClass = 'EntitiesController';
            $modelSourceClass = 'Entity';
        }
        else
        {
            $controllerSourceClass = 'EntityModelsController';
            $modelSourceClass = 'EntityModel';
        }

        $modelClass = $model;
        $shortClassName = $this->getShortNameClass($modelClass);
        $pluralModel = (!empty($pluralEntityName))? $pluralEntityName : strtolower(Str::plural($shortClassName));

        $controllerClass = $controller;

        $controllerNamespace = $this->getRootNamespaceController();
        if (!empty($controllerDir))
        {
            $controllerNamespace .= '\\'.$controllerDir;
        }

        $controllerFullClass = $controllerNamespace.'\\'.$controller;

        $pathControllerDir = $this->getPathControllers();

        if (!empty($controllerDir))
        {
            $pathControllerDir .= '/'.$controllerDir;
        }


        $controllerFile = $pathControllerDir. '/'. $controllerClass.'.php';

        if (!class_exists($modelClass))
        {
            $this->error('Model class : '. $modelClass . ' does not exists !');
            exit(0);
        }

        if (class_exists($controllerFullClass) && !$overrideController && !$byPassController)
        {
            $this->error('Controller class : '. $controllerFullClass . ' already exists. Use option --oc to override or --bc to bypass!');
            exit(0);
        }


        if (!$byPassController )
        {
            //Create controller directory and controller file if not exists

            if (!file_exists($pathControllerDir))
            {
                $this->fileSystem->makeDirectory($pathControllerDir);
            }

            if (!file_exists($controllerFile) || $overrideController)
            {

                $this->fileSystem->copy(__DIR__. '/../Http/Controllers/'.$controllerSourceClass.'.php', $controllerFile);

            }

            if (file_exists($controllerFile))
            {
                //replace namespace
                $cmd = "sed -i 's/class\s{$controllerSourceClass}/class ".$controllerClass."/g' ".$controllerFile;
                //echo $cmd;
                $output = exec($cmd);

                //replace controller class name
                $cmd = "sed -i 's/Permaxis\\\\Laravel\\\\CrudGenerator\\\\App\\\\Http\\\\Controllers/".str_replace('\\','\\\\',$controllerNamespace)."/g' ".$controllerFile;
                //echo $cmd;
                $output = exec($cmd);

                //replace Model Class Permaxis\Laravel\CrudGenerator\app\Entities\ApiEntity by modelClass
                $cmd = "sed -i 's/use\sPermaxis\\\\Laravel\\\\CrudGenerator\\\\App\\\\Entities\\\\{$modelSourceClass}/use ".str_replace('\\','\\\\',$modelClass)."/g' ".$controllerFile;
                $output = exec($cmd);

                //replace routes names in controller
                $this->replaceRouteNames($routeNamePrefix,$pluralModel,$controllerFile);

                //replace views names in controller
                $this->replaceViewNames($subViewsDir,$pluralModel,$controllerFile, $packageName);

                //comment attributes in controller
                if ($enabledComment)
                {
                    $this->replaceInFile('\/\*bc\*\/','\/\*',$controllerFile);
                    $this->replaceInFile('\/\*ec\*\/','\*\/',$controllerFile);
                }

            }

        }

        if (!$byPassViews)
        {
            //copy views directory for model class
            $viewsDir = '';
            if (!empty($subViewsDir))
            {
                $viewsDir = '/'. $subViewsDir;
            }

            $viewsDir = $this->getPathViews().$viewsDir;

            if (file_exists($viewsDir) && !$overrideViews && !$byPassViews)
            {
                $this->error('View directory : '. $viewsDir.'/'.$pluralModel . ' already exists. Use option --ov to override  or --bv to bypass!');
            }

            if (!file_exists($viewsDir))
            {
                $this->fileSystem->makeDirectory($viewsDir,0755,true);
            }

            if (file_exists($viewsDir))
            {
                $sourceViewsDir = __DIR__.'/../../resources/views';
                if (!file_exists($sourceViewsDir))
                {
                    throw new\Exception($sourceViewsDir .' does not exists');
                }

                //copy entities dir to target dir;
                $targetViews = $viewsDir.'/'.$pluralModel;
                $this->fileSystem->copyDirectory($sourceViewsDir.'/entities',$targetViews);
                foreach ($this->fileSystem->allFiles($targetViews) as $file)
                {
                    //replace routes names in views
                    $this->replaceRouteNames($routeNamePrefix, $pluralModel, $file);

                    //comment attributes in views
                    if ($enabledComment)
                    {
                        $this->replaceInFile('{{--bc--}}','{{--',$file);
                        $this->replaceInFile('{{--ec--}}','--}}',$file);
                        $this->replaceInFile('\/\*bc\*\/','\/\*',$file);
                        $this->replaceInFile('\/\*ec\*\/','\*\/',$file);
                    }

                    //replace views names in views
                    $this->replaceViewNames($subViewsDir,$pluralModel,$file,$packageName);

                    //replace translations
                    $this->replaceInFile('::messages.', '::'.$pluralModel.'.', $file);

                };

                //copy layouts dir to target dir;
                $targetViews = $viewsDir.'/layouts';
                if (!file_exists($targetViews)) {
                    $this->fileSystem->copyDirectory($sourceViewsDir.'/layouts',$targetViews);
                    foreach ($this->fileSystem->allFiles($targetViews) as $file)
                    {
                        //replace routes names in layouts
                        $this->replaceRouteNames($routeNamePrefix, $pluralModel, $file);

                        //replace views names in layouts
                        $this->replaceViewNames($subViewsDir, $pluralModel, $file, $packageName);

                    };
                }

            }

        }


    }

    /**
     * @param $className
     * @return string
     *
     * get shot name of class without namespace
     */
    public function getShortNameClass($className)
    {
        $class = new \ReflectionClass($className);
        return $class->getShortName();
    }


    public function replaceRouteNames($routeNamePrefix= '', $pluralModel, $file)
    {
        if (!empty($routeNamePrefix))
        {
            $route_name = $routeNamePrefix.'.'.$pluralModel.'.';
        }
        else
        {
            $route_name = 'crudgenerator.'.$pluralModel.'.';
        }

        $cmd = "sed -i 's/crudgenerator.entities./".$route_name."/g' ".$file;

        $output = exec($cmd);

        $cmd = "sed -i 's/destroy_entities/".'destroy_'.$pluralModel."/g' ".$file;

        $output = exec($cmd);

    }

    public function replaceViewNames($subViewDir = '', $pluralModel, $file, $packageName = '')
    {
        $dir = '';
        if (!empty($subViewDir))
        {
            $dir = $subViewDir .'\/';
        }

        $view_name = $dir.$pluralModel.'.';

        if (!empty($packageName))
        {
            $view_name = $packageName.'::'.$view_name;
        }

        //replace view model names
        $cmd = "sed -i 's/crudgenerator::entities./".$view_name."/g' ".$file;
        $output = exec($cmd);

        //replace  view layouts name
        $layout_name = $dir.'layouts.';
        $cmd = "sed -i 's/crudgenerator::layouts./".$layout_name."/g' ".$file;
        $output = exec($cmd);

    }

    public function replaceInFile($str_source, $str_target, $file)
    {
        $cmd = "sed -i 's/{$str_source}/{$str_target}/g' ".$file;
        $output = exec($cmd);
    }

}
