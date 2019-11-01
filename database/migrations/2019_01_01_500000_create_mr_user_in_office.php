<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmruserinoffice extends Migration
{
  public function up()
  {
    Schema::create('mr_user_in_office', function (Blueprint $table) {
      $table->increments('id')->autoIncrement();
      $table->integer('UserID');
      $table->integer('OfficeID');
      $table->boolean('IsAdmin');
      $table->timestamp('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_user_in_office');
  }
}
