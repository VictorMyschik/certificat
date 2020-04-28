<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrTechnicalReglamentTable extends Migration
{
  public function up()
  {
    Schema::create('mr_technical_reglament', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('Code', 10);
      $table->string('Name');
      $table->string('Link');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_technical_reglament');
  }
}