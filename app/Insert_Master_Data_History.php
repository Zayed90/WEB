<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insert_Master_Data_History extends Model
{
    protected $table = 'insert_master_data_histories';
    protected $primaryKey = 'id';
    protected $fillable = ['company_name', 'address', 'source'];
    public $timestamps = false;
}
