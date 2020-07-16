<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDeduplicationTableResult extends Model
{
  protected $table = 'data_deduplication_table_result';
  protected $primaryKey = 'id';
  public $timestamps = false;

}
