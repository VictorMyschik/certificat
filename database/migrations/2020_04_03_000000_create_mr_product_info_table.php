<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrProductInfoTable extends Migration
{
  public function up()
  {
    Schema::create('mr_product_info', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('ProductID');
      $table->integer('MeasureID')->nullable();
      $table->string('InstanceId', 50)->nullable(); //Заводской номер единичного изделия или обозначение у группы одинаковых единиц продукции
      $table->string('Name', 500)->nullable();
      $table->string('Description', 4000)->nullable(); //Дополнительные сведения о продукции, обеспечивающие ее идентификацию
      $table->date('ManufacturedDate')->nullable();//Дата изготовления
      $table->date('ExpiryDate')->nullable();//Дата истечения срока годности
      $table->string('Tnved', 10)->nullable();//Значение кода из ТН ВЭД ЕАЭС на уровне 2, 4, 6, 8, 9 или 10 знаков. Шаблон: \d{2}|\d{4}|\d{6}|\d{8,10}
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_product_info');
  }
}