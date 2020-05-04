<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrMeasureTable extends Migration
{
  public function up()
  {
    Schema::create('mr_measure', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->string('Code', 3);
      $table->string('TextCode', 20);
      $table->string('Name', 50);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_measure');
  }
}