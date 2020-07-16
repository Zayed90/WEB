<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clustering extends Model
{
    //
    protected $table = 'data_pentaho';
    public $timestamps = false;
    protected $fillable = ['NAMA_NEW','JUMLAH','FINGERPRINT'];
}
