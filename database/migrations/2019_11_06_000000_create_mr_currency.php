<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrcurrency extends Migration
{
  public function up()
  {
    Schema::create('mr_currency', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Code', 3);
      $table->string('TextCode', 3);
      $table->date('DateFrom');
      $table->date('DateTo');
      $table->string('Name', 200);
      $table->tinyInteger('Rounding');
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
    Schema::dropIfExists('mr_currency');
  }
}
