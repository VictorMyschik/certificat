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
      $table->tinyInteger('Kind')->default(0);// Тип: телефон, email, факс...
      $table->tinyInteger('')

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