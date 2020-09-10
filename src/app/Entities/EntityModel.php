<?php

namespace Permaxis\LaravelCrudGenerator\app\Entities;

use Illuminate\Database\Eloquent\Model;
use Permaxis\LaravelCore\app\Services\Entities\ModelManager;

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
