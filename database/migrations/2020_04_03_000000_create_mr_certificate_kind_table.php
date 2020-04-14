<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrCertificateKindTable extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate_kind', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->string('Code', 2);
      $table->string('ShortName');
      $table->string('Name', 400);
      $table->string('Description', 350)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_certificate_kind');
  }
}