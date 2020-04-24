<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrDocumentTable extends Migration
{
  public function up()
  {
    Schema::create('mr_document', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->integer('CertificateID');
      $table->tinyInteger('Kind');
      $table->string('Name', 500);
      $table->string('Number', 50)->nullable();
      $table->date('Date')->nullable();
      $table->date('DateFrom')->nullable();
      $table->date('DateTo')->nullable();
      $table->string('Organisation', 300)->nullable();
      $table->string('Accreditation', 120)->nullable();
      $table->string('Description')->nullable();
      $table->tinyInteger('IsIncludeIn')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_document');
  }
}
