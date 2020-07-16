<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Logins extends Authenticatable
{
    //
    protected $table = 'logins';
    public $timestamps = true;
    protected $fillable = ['id','name','username','password','status','remember_token','created_at'];
    protected $primaryKey = 'id';
}
