<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrCertificateTechnicalReglamentTable extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate_technical_reglament', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->integer('CertificateID');
      $table->integer('TechnicalReglamentID');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_certificate_technical_reglament');
  }
}