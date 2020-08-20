<?php

namespace Permaxis\Laravel\CrudGenerator\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Permaxis\Core\App\Services\Entities\ModelManager;

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
