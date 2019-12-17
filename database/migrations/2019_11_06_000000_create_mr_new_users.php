<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrnewusers extends Migration
{
  public function up()
  {
    Schema::create('mr_new_users', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Email',50);
      $table->smallInteger('UserID');
      $table->boolean('IsAdmin')->default(false);
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
    Schema::dropIfExists('mr_new_users');
  }
}
