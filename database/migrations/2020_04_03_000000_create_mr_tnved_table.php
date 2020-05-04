<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrTnvedTable extends Migration
{
  public function up()
  {
    Schema::create('mr_tnved', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Code',10)->unique();
      $table->string('Name', 120)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_tnved');
  }
}