<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmrcertificatedetails extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate_details', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('CertificateID');
      $table->string('Field');
      $table->string('Value', 8000);
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
    Schema::dropIfExists('mr_certificate_details');
  }
}
