<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrProductTable extends Migration
{
  public function up()
  {
    Schema::create('mr_product', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('CertificateID');
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
    Schema::dropIfExists('mr_product');
  }
}