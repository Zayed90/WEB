<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDQResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_q_results', function (Blueprint $table) {
            $table->increments('dq_id');
            $table->string('dq_time_id');
            $table->string('dq_dimension_id');
            $table->string('dq_rule_id');
            $table->string('dq_field_id');
            $table->integer('pass_record');
            $table->integer('fail_record');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_q_results');
    }
}
