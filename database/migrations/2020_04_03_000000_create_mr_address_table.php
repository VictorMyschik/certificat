<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrAddressTable extends Migration
{
  public function up()
  {
    Schema::create('mr_address', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->tinyInteger('ObjectKind'); // к чему привязан
      $table->unsignedBigInteger('ObjectID');// ID в объекте приязки
      $table->integer('CountryID'); // Страна
      $table->string('City')->nullable();
      $table->string('Building')->nullable();
      $table->string('Address')->nullable();
      $table->string('Lat')->nullable();
      $table->string('Lon')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_address');
  }
}