<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmremaillog extends Migration
{
  public function up()
  {
    Schema::create('mr_email_log', function (Blueprint $table) {
      $table->increments('id')->autoIncrement();
      $table->integer('UserID');
      $table->string('Email');
      $table->string('Title');
      $table->text('Text')->nullable();
      $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_email_log');
  }
}
