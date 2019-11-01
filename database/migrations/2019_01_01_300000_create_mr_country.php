<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrcountry extends Migration
{
  public function up()
  {
    Schema::create('mr_country', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('NameRus')->nullable();
      $table->string('NameEng')->nullable();
      $table->string('Code')->nullable();
      $table->string('NumericCode')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_country');
  }
}
