<?php

namespace App\Redaxo;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @mixin BaseModel
 * @mixin Builder
 * @property Carbon $createdate
 * @property Carbon $updatedate
 */
class Model extends BaseModel
{
    const CREATED_AT = 'createdate';
    const UPDATED_AT = 'updatedate';
    
    protected $connection = 'redaxo';

    public function getTable()
    {
        if (!isset($this->table)) {
            return str_replace('\\', '', snake_case(class_basename($this)));
        }
        return $this->table;
    }
}