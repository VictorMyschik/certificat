<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrFaqTable extends Migration
{
  public function up()
  {
    Schema::create('mr_faq', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Title')->unique();
      $table->string('Text', 8000);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_faq');
  }
}
