<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrTranslateTable extends Migration
{
  public function up()
  {
    Schema::create('mr_translate', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name')->nullable();
      $table->integer('LanguageID');
      $table->string('Translate');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_translate');
  }
}
