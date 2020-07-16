<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dataPerusahaan extends Model
{
    protected $table="data_perusahaan";
    protected $primaryKey="id";
    public $timestamps=false;
}
