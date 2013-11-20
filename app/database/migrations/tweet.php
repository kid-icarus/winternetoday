<?php

use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration {

  public function up() {
    Schema::create('tweets', function($tbl) {
      $tbl->increments('id');
      $tbl->integer('day_id');
    });
  }
  
  public function down() {
    Schema::drop('tweets');
  }

}