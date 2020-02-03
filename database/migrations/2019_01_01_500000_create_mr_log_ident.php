<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrlogident extends Migration
{
  public function up()
  {
    Schema::create('mr_log_ident', function (Blueprint $table) {
      $table->increments('id')->autoIncrement();
      $table->timestamp('Date')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->string('Referer', 512)->nullable();
      $table->string('Link', 512)->nullable();
      $table->string('Ip', 16);
      $table->mediumInteger('UserID', false, true)->nullable();
      $table->string('UserAgent', 800);
      $table->string('City')->nullable();
      $table->string('Country')->nullable();
      $table->string('Cookie')->nullable();
      $table->tinyInteger('LanguageID')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_log_ident');
  }
}
