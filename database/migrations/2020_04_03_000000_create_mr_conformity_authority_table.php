<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Сведения единого реестра органов по оценке соответствия
 */
class CreateMrConformityAuthorityTable extends Migration
{
  public function up()
  {
    Schema::create('mr_conformity_authority', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->smallInteger('CountryID');// кодовое обозначение страны, в которой зарегистрирован орган по оценке соответствия
      $table->string('Name', 300);//Наименование (в том числе наименование юридического лица)
      $table->string('ConformityAuthorityId', 40);//номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
      $table->string('DocumentNumber', 50);// номер документа, подтверждающего аккредитацию органа по оценке соответствия
      $table->date('DocumentDate'); // дата регистрации документа подтверждающего аккредитацию органа по оценке соответствия
      $table->bigInteger('OfficerDetailsID')->nullable();// Руководитель органа по оценке соответствия
      $table->bigInteger('Address1ID')->nullable(); // юридический адрес
      $table->bigInteger('Address2ID')->nullable(); // фактический адрес
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_conformity_authority');
  }
}