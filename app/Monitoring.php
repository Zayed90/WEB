<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    //
    protected $table = 'detail_monitor';
    public $timestamps = false;
    protected $fillable = ['NAMA_TABEL','KOLOM_TABEL','JUMLAH_CLUSTERING','JUMLAH_NULL','JUMLAH_PATTERN'];
}
