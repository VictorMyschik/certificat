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
      $table->tinyInteger('ObjectKind')->default(0);//К чему привязан
      $table->bigInteger('ObjectID');//ID объекта
      $table->string('FirstName', 121)->nullable();//Имя
      $table->string('MiddleName', 121)->nullable();//Отчество
      $table->string('LastName', 121)->nullable();//Фамилия
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