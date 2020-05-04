<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrSubscriptionTable extends Migration
{
  public function up()
  {
    Schema::create('mr_subscription', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Email')->unique();
      $table->dateTime('Date');
      $table->string('Token', 50)->unique();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_subscription');
  }
}
