<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrtariffinoffice extends Migration
{
  public function up()
  {
    Schema::create('mr_tariff_in_office', function (Blueprint $table) {
      $table->Increments('id')->autoIncrement();
      $table->integer('OfficeID');
      $table->integer('TariffID');
      $table->timestamp('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_tariff_in_office');
  }
}
