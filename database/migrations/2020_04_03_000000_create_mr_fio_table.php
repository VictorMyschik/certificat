<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrFioTable extends Migration
{
  public function up()
  {
    Schema::create('mr_fio', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->string('FirstName', 120)->nullable();//Имя
      $table->string('MiddleName', 120)->nullable();//Отчество
      $table->string('LastName', 120)->nullable();//Фамилия
      $table->string('PositionName', 120)->nullable();//Фамилия
      $table->string('Hash', 32);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_fio');
  }
}