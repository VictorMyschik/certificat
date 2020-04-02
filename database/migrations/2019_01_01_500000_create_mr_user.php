<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMrUser extends Migration
{
  public function up()
  {
    Schema::create('mr_users', function (Blueprint $table) {
      $table->increments('id')->autoIncrement();
      $table->integer('UserLaravelID')->unique();
      $table->string('Telegram')->unique();
      $table->dateTime('DateFirstVisit');
      $table->dateTime('DateLogin')->nullable();
      $table->integer('DefaultOfficeID')->nullable();
      $table->timestamp('DateLastVisit')->default(DB::raw('CURRENT_TIMESTAMP'));

      $table->string('Phone', 18)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_users');
  }
}
