<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Сведения о документе
 */
class CreateMrCertificateTable extends Migration
{
  public function up()
  {
    Schema::create('mr_certificate', function (Blueprint $table) {
      $table->bigIncrements('id')->autoIncrement();
      $table->integer('Kind');//Регистрационный номер документа
      $table->string('Number', 50);//Регистрационный номер документа
      $table->date('DateFrom');//Дата начала срока действия
      $table->date('DateTo')->nullable();//Дата окончания срока действия
      $table->integer('CountryID');//Страна
      $table->tinyInteger('Status')->default(0);//Статус действия | Действует

      $table->string('Auditor', 80);//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
      $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
      $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
      $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
      $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
      $table->string('WhyChange')->nullable();//Причина изменения статуса

      $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
      $table->string('Description', 1000)->nullable();// Дополнительные сведения

      $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат
      $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи
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
