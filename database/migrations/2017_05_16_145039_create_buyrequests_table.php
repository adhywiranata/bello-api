<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('buyrequests', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('user_id');
          $table->string('keyword');
          $table->integer('is_purchase');
          $table->string('is_cancel');
          $table->string('cancelation_reason');
          $table->date('reminder_schedule');
          $table->integer('is_read');
          $table->string('is_delete');
          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buyrequests');
    }
}
