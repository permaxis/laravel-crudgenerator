<?php
/**
 * Created by Permaxis.
 * User: abdel
 * Date: 04/10/2019
 * Time: 12:40
 */

namespace Permaxis\LaravelCrudGenerator\app\Entities;

use Permaxis\Laravel\Core\App\Services\Entities\AbstractApiModelManager;
use Permaxis\Laravel\Core\App\Services\Entities\ApiValidateModelManager;

class Entity extends AbstractApiModelManager
{
    use ApiValidateModelManager;

    protected static $config_properties =  [
        'base_url' => 'entities',
        'resource_type' => 'entities',
        'api_client_name' => 'api_v1'
    ];

    protected static $attributes =  [
        'id','name','enabled','created_at','updated_at'
    ];

}