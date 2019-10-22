<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrfeedback extends Migration
{
  public function up()
  {
    Schema::create('mr_feedback', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name');
      $table->string('Email');
      $table->string('Text', 8000);
      $table->dateTime('Date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_feedback');
  }
}
