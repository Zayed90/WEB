<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update_Master_Data_History extends Model
{
    //
    protected $table = "update_master_data_histories";
    protected $primaryKey = "id";
    protected $fillable = ['company_name', 'address', 'data_source',
        'master_data_id','master_data_company_name','master_data_address','master_data_source'];
    public $timestamps = false;
}
