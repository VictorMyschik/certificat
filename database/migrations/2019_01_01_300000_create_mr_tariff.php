<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrtariff extends Migration
{
  public function up()
  {
    Schema::create('mr_tariff', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name', 50);
      $table->tinyInteger('Measure');
      $table->float('Cost');
      $table->string('Description')->nullable();
      $table->string('Category');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_tariff');
  }
}
