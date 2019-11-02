<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrdiscount extends Migration
{
  public function up()
  {
    Schema::create('mr_discount', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name');
      $table->string('Kind');
      $table->datetime('DateFrom');
      $table->datetime('DateTo');
      $table->string('Description', 8000);
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
    Schema::dropIfExists('mr_discount');
  }
}
