<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiProccess extends Model
{
    protected $table = 'multi_proccess_result';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
