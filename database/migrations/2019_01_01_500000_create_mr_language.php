<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrlanguage extends Migration
{
  public function up()
  {
    Schema::create('mr_language', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name');
      $table->string('Description')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_language');
  }
}
