<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatabaseConnection extends Model
{
    protected $table = 'database_settings';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
