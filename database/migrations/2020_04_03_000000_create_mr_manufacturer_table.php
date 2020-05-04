<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrManufacturerTable extends Migration
{
  public function up()
  {
    Schema::create('mr_manufacturer', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->smallInteger('CountryID')->nullable();//Страна производителя
      $table->string('Name');//Юр наименование
      $table->string('Address1ID')->nullable();//адрес регистрации
      $table->string('Address2ID')->nullable();//фактический адрес
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_manufacturer');
  }
}