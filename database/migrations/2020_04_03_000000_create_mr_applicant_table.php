<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Сведения единого реестра органов по оценке соответствия
 */
class CreateMrApplicantTable extends Migration
{
  public function up()
  {
    Schema::create('mr_applicant', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('CountryID');
      $table->string('Name', 300);//Наименование хозяйствующего субъекта
      $table->integer('Address1ID')->nullable();
      $table->integer('Address2ID')->nullable();
      $table->integer('FioID')->nullable();
      $table->string('Hash', 32);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_applicant');
  }
}