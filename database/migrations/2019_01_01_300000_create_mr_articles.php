<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrarticles extends Migration
{
  public function up()
  {
    Schema::create('mr_articles', function (Blueprint $table) {
      $table->smallIncrements('id');
      $table->tinyInteger('Kind');
      $table->smallInteger('LanguageID');
      $table->text('Text');
      $table->dateTime('DateUpdate');
      $table->boolean('IsPublic');
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
    Schema::dropIfExists('mr_articles');
  }
}
