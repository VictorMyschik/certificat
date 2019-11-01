<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createmroffice extends Migration
{
  public function up()
  {
    Schema::create('mr_office', function (Blueprint $table) {
      $table->smallIncrements('id')->autoIncrement();
      $table->string('Name');//Полное наименование
      $table->string('UNP', 10)->nullable();
      $table->smallInteger('CountryID')->nullable();
      // Email для выставления счетов и отправки уведомлений
      $table->string('Email', 50)->nullable();
      $table->string('Phone', 16)->nullable();
      // Почтовый адрес
      $table->string('POPostalCode', 50)->nullable();
      $table->string('PORegion', 50)->nullable();
      $table->string('POCity', 50)->nullable();
      $table->string('POAddress', 500)->nullable();
      // Юр адрес
      $table->string('URPostalCode', 50)->nullable();
      $table->string('URRegion', 50)->nullable();
      $table->string('URCity', 50)->nullable();
      $table->string('URAddress', 500)->nullable();
      // Расчётный счёт в банке
      $table->string('BankRS')->nullable(); //Номер р/с
      $table->string('BankName')->nullable(); //Банк
      $table->string('BankCode')->nullable(); //Код банка
      $table->string('BankAddress', 500)->nullable(); //Адрес банка
      //// Лицо с правом подписи договора
      $table->string('PersonSign')->nullable(); // Действует на основании
      $table->string('PersonPost')->nullable(); // Должность
      $table->string('PersonFIO')->nullable(); // ФИО

      $table->string('Description')->nullable(); // Примечание для админа
      $table->timestamp('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mr_office');
  }
}
