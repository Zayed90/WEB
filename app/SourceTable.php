<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceTable extends Model
{
    protected $table = 'shownull_table_result';
    public function setTable($table){
      $this->table = $table;
      return $table;
    }
}
