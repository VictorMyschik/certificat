<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMrBaseLog extends Migration
{
  public function up()
  {
    Schema::create('mr_base_log', function (Blueprint $table) {
      $table->Increments('id')->autoIncrement();
      $table->integer('LogIdentID')->default(0);
      $table->string('TableName');
      $table->integer('RowId');
      $table->string('Field');
      $table->text('Value')->nullable();
      $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_base_log');
  }
}
