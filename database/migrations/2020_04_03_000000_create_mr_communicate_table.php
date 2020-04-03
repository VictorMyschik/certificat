<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrCommunicateTable extends Migration
{
  public function up()
  {
    Schema::create('mr_communicate', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->tinyInteger('KindObject')->default(0);//К чему привязан
      $table->bigInteger('ObjectID');//ID объекта
      $table->tinyInteger('Kind')->default(0);// Тип: телефон, email, факс...
      $table->string('Address');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_communicate');
  }
}