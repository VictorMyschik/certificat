<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrdiscount extends Migration
{
  public function up()
  {
    Schema::create('mr_discount', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->integer('OfficeID');
      $table->integer('TariffID')->nullable();
      $table->tinyInteger('Kind');
      $table->date('DateFrom');
      $table->date('DateTo');
      $table->float('Amount');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_discount');
  }
}
