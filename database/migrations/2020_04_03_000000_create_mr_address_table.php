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
      $table->tinyInteger('AddressKind'); // Кодовое обозначение вида адреса
      $table->integer('CountryID')->nullable(); // Страна
      $table->string('TerritoryCode', 18)->nullable();
      $table->string('RegionName', 121)->nullable();
      $table->string('DistrictName', 121)->nullable();
      $table->string('City', 121)->nullable();
      $table->string('SettlementName', 121)->nullable();
      $table->string('StreetName', 121)->nullable();
      $table->string('BuildingNumberId', 51)->nullable();
      $table->string('RoomNumberId', 21)->nullable();
      $table->string('PostCode', 11)->nullable();
      $table->string('PostOfficeBoxId', 21)->nullable();
      $table->string('AddressText', 1001)->nullable();
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