<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMrCertificate extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->integer('Kind');
      $table->string('Number');
      $table->date('DateFrom');
      $table->date('DateTo')->nullable();
      $table->string('CountryID');
      $table->string('Status');
      $table->string('LinkOut')->nullable();
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
    Schema::dropIfExists('mr_certificate');
  }
}
