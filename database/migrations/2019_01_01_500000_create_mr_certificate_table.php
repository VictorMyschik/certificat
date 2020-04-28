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
      $table->integer('CertificateKindID');//Регистрационный номер документа
      $table->string('Number', 50)->unique();//Регистрационный номер документа
      $table->date('DateFrom');//Дата начала срока действия
      $table->date('DateTo')->nullable();//Дата окончания срока действия
      $table->integer('CountryID');//Страна
      $table->tinyInteger('Status')->default(0);//Статус действия | Действует

      $table->bigInteger('AuditorID')->nullable();//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
      $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
      $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
      $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
      $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
      $table->string('WhyChange')->nullable();//Причина изменения статуса
      $table->boolean('SingleListProductIndicator');//признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о соответствии по единой форме: 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня

      $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
      $table->string('Description', 1000)->nullable();// Дополнительные сведения
      $table->integer('AuthorityID')->nullable();//Сведения об органе по оценке соответствия
      $table->dateTime('DateUpdateEAES')->nullable();//Дата обновления на сайте ЕАЭС

      $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат
      $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи

      $table->integer('ManufacturerID')->nullable();//Сведения об органе по оценке соответствия
      $table->integer('ApplicantID')->nullable();//Сведения об органе по оценке соответствия
      $table->integer('TechnicalRegulationKindID')->nullable();// Кодовое обозначение вида объекта технического регулирования
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
