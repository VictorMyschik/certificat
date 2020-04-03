<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrCountryTable extends Migration
{
  public function up()
  {
    Schema::create('mr_countries', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name',50);
      $table->char('ISO3166alpha2',3);
      $table->char('ISO3166alpha3',4);
      $table->char('ISO3166numeric',3);
      $table->string('Capital',50);
      $table->tinyInteger('Continent');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_countries');
  }
}
