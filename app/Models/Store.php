<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $connection = 'mysql';
    protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
}
