<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMrCertificateMonitoringTable extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate_monitoring', function (Blueprint $table) {
      $table->Increments('id')->autoIncrement();
      $table->integer('OfficeID');
      $table->integer('CertificateID')->unsigned();
      $table->string('Description', 1000)->nullable();
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
    Schema::dropIfExists('mr_certificate_monitoring');
  }
}
