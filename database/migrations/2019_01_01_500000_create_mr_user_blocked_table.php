<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrUserBlockedTable extends Migration
{
  public function up()
  {
    Schema::create('mr_user_blocked', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->integer('UserID');
      $table->string('Description', 8000)->nullable();
      $table->timestamp('DateFrom');
      $table->dateTime('DateTo')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_user_blocked');
  }
}
