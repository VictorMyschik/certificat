<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrbotuseragent extends Migration
{
  public function up()
  {
    Schema::create('mr_bot_useragent', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('UserAgent');
      $table->string('Description');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_bot_useragent');
  }
}
