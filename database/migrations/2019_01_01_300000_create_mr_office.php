<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmroffice extends Migration
{
  public function up()
  {
    Schema::create('mr_office', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name');
      $table->integer('AdminID');
      $table->integer('TariffID');
      $table->integer('Description');
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
    Schema::dropIfExists('mr_office');
  }
}
