<?php

namespace Permaxis\LaravelCrudGenerator\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Permaxis\Laravel\Core\App\Services\Entities\ModelManager;

class EntityModel extends Model
{
    use ModelManager;

    protected $fillable = [
        'name',
        'enabled',
   ];

    protected static $rules = array(
        'name' => 'required',
        'enabled' => 'required'
    );
}
