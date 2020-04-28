<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrProductTable extends Migration
{
  public function up()
  {
    Schema::create('mr_product', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('CertificateID');
      $table->string('Name', 120)->nullable();
      $table->string('EANCommodityId', 13)->nullable();//Значение идентификатора в соответствии с правилами формирования штрихкода EAN-8 или EAN-13 стандарта GS1. Шаблон: \d{8}|\d{13}
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_product');
  }
}