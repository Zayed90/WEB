<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    //
    protected $table = 'data_nama';
    public $timestamps = false;
    protected $guarded = ['PABRIK_ID','FINGERPRINT'];
    protected $primaryKey = 'PABRIK_ID';

}
