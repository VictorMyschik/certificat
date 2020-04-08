<?php


namespace Tests\Feature;


use App\Helpers\MrDateTime;
use App\Models\MrCertificate;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrCertificateTest extends TestCase
{
  public function testCertificate()
  {
    /*
    'id',// $table->bigIncrements('id')->autoIncrement();
    'Kind',// $table->integer('Kind');//Тип документа
    'Number',// $table->string('Number');//Регистрационный номер документа
    'DateFrom',// $table->date('DateFrom');//Дата начала срока действия
    'DateTo',// $table->date('DateTo')->nullable();//Дата окончания срока действия
    'CountryID',// $table->integer('CountryID');//Страна
    'Status',// $table->tinyInteger('Status')->default(0);//Статус действия | Действует
    'Auditor',// $table->string('Auditor', 80);//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
    'BlankNumber',// $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
    'DateStatusFrom',// $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DateStatusTo',// $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DocumentBase',// $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
    'WhyChange',// $table->string('WhyChange')->nullable();//Причина изменения статуса
    'SchemaCertificate',// $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
    'Description',// $table->string('Description', 1000)->nullable();//Примечание для себя
    'LinkOut',// $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат
    ///'WriteDate' // $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи
    */

    $certificate = new MrCertificate();
    //'Kind'
    $kind = array_rand(MrCertificate::getKinds());
    $certificate->setKind($kind);
    //'Number'
    $Number = self::randomString(10);
    $certificate->setNumber($Number);
    //'DateFrom'
    $DateFrom = MrDateTime::now();
    $certificate->setDateFrom($DateFrom);
    //'DateTo'
    $DateTo = MrDateTime::now();
    $certificate->setDateTo($DateTo);
    //'CountryID'
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $certificate->setCountryID($CountryID);
    //'Status'
    $Status = array_rand(MrCertificate::getStatuses());
    $certificate->setStatus($Status);
    //'Auditor'
    $Auditor = self::randomString(80);
    $certificate->setAuditor($Auditor);
    //'BlankNumber'
    $BlankNumber = self::randomString(50);
    $certificate->setBlankNumber($BlankNumber);
    //'DateStatusFrom'
    $DateStatusFrom = MrDateTime::now();
    $certificate->setDateStatusFrom($DateStatusFrom);
    //'DateStatusTo'
    $DateStatusTo = MrDateTime::now();
    $certificate->setDateStatusTo($DateStatusTo);
    //'DocumentBase'
    $DocumentBase = self::randomString(255);
    $certificate->setDocumentBase($DocumentBase);
    //'WhyChange'
    $WhyChange = self::randomString(255);
    $certificate->setWhyChange($WhyChange);
    //'SchemaCertificate'
    $SchemaCertificate = self::randomString(3);
    $certificate->setSchemaCertificate($SchemaCertificate);
    //'Description'
    $Description = self::randomString(1000);
    $certificate->setDescription($Description);
    //'LinkOut'
    $LinkOut = self::randomString(255);
    $certificate->setLinkOut($LinkOut);

    $certificate_id = $certificate->save_mr();
    $certificate->flush();


    //// Asserts
    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);
    $this->assertEquals($certificate->getKind(), $kind);
    $this->assertEquals($certificate->getNumber(), $Number);
    $this->assertEquals($certificate->getDateFrom()->getShortDate(), $DateFrom->getShortDate());
    $this->assertEquals($certificate->getDateTo()->getShortDate(), $DateTo->getShortDate());
    $this->assertEquals($certificate->getCountry()->id(), $CountryID);
    $this->assertEquals($certificate->getStatus(), $Status);
    $this->assertEquals($certificate->getAuditor(), $Auditor);
    $this->assertEquals($certificate->getBlankNumber(), $BlankNumber);
    $this->assertEquals($certificate->getDateStatusFrom()->getShortDate(), $DateStatusFrom->getShortDate());
    $this->assertEquals($certificate->getDateStatusTo()->getShortDate(), $DateStatusTo->getShortDate());
    $this->assertEquals($certificate->getDocumentBase(), $DocumentBase);
    $this->assertEquals($certificate->getWhyChange(), $WhyChange);
    $this->assertEquals($certificate->getSchemaCertificate(), $SchemaCertificate);
    $this->assertEquals($certificate->getDescription(), $Description);
    $this->assertEquals($certificate->getLinkOut(), $LinkOut);


    //// Update
    //'Kind'
    $kind = array_rand(MrCertificate::getKinds());
    $certificate->setKind($kind);
    //'Number'
    $Number = self::randomString(10);
    $certificate->setNumber($Number);
    //'DateFrom'
    $DateFrom = MrDateTime::now();
    $certificate->setDateFrom($DateFrom);
    //'DateTo'
    $DateTo = MrDateTime::now();
    $certificate->setDateTo($DateTo);
    //'CountryID'
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $certificate->setCountryID($CountryID);
    //'Status'
    $Status = array_rand(MrCertificate::getStatuses());
    $certificate->setStatus($Status);
    //'Auditor'
    $Auditor = self::randomString(80);
    $certificate->setAuditor($Auditor);
    //'BlankNumber'
    $BlankNumber = self::randomString(50);
    $certificate->setBlankNumber($BlankNumber);
    //'DateStatusFrom'
    $DateStatusFrom = MrDateTime::now();
    $certificate->setDateStatusFrom($DateStatusFrom);
    //'DateStatusTo'
    $DateStatusTo = MrDateTime::now();
    $certificate->setDateStatusTo($DateStatusTo);
    //'DocumentBase'
    $DocumentBase = self::randomString(255);
    $certificate->setDocumentBase($DocumentBase);
    //'WhyChange'
    $WhyChange = self::randomString(255);
    $certificate->setWhyChange($WhyChange);
    //'SchemaCertificate'
    $SchemaCertificate = self::randomString(3);
    $certificate->setSchemaCertificate($SchemaCertificate);
    //'Description'
    $Description = self::randomString(1000);
    $certificate->setDescription($Description);
    //'LinkOut'
    $LinkOut = self::randomString(255);
    $certificate->setLinkOut($LinkOut);

    $certificate_id = $certificate->save_mr();
    $certificate->flush();

    //// Asserts
    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);
    $this->assertEquals($certificate->getKind(), $kind);
    $this->assertEquals($certificate->getNumber(), $Number);
    $this->assertEquals($certificate->getDateFrom()->getShortDate(), $DateFrom->getShortDate());
    $this->assertEquals($certificate->getDateTo()->getShortDate(), $DateTo->getShortDate());
    $this->assertEquals($certificate->getCountry()->id(), $CountryID);
    $this->assertEquals($certificate->getStatus(), $Status);
    $this->assertEquals($certificate->getAuditor(), $Auditor);
    $this->assertEquals($certificate->getBlankNumber(), $BlankNumber);
    $this->assertEquals($certificate->getDateStatusFrom()->getShortDate(), $DateStatusFrom->getShortDate());
    $this->assertEquals($certificate->getDateStatusTo()->getShortDate(), $DateStatusTo->getShortDate());
    $this->assertEquals($certificate->getDocumentBase(), $DocumentBase);
    $this->assertEquals($certificate->getWhyChange(), $WhyChange);
    $this->assertEquals($certificate->getSchemaCertificate(), $SchemaCertificate);
    $this->assertEquals($certificate->getDescription(), $Description);
    $this->assertEquals($certificate->getLinkOut(), $LinkOut);


    //// NUll
    //'DateTo'
    $certificate->setDateTo(null);
    //'BlankNumber'
    $certificate->setBlankNumber(null);
    //'DateStatusFrom'
    $certificate->setDateStatusFrom(null);
    //'DateStatusTo'
    $certificate->setDateStatusTo(null);
    //'DocumentBase'
    $certificate->setDocumentBase(null);
    //'WhyChange'
    $certificate->setWhyChange(null);
    //'SchemaCertificate'
    $certificate->setSchemaCertificate(null);
    //'Description'
    $certificate->setDescription(null);
    //'LinkOut'
    $certificate->setLinkOut(null);

    $certificate_id = $certificate->save_mr();

    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);

    //// Asserts
    $this->assertNull($certificate->getDateTo());
    $this->assertNull($certificate->getBlankNumber());
    $this->assertNull($certificate->getDateStatusFrom());
    $this->assertNull($certificate->getDateStatusTo());
    $this->assertNull($certificate->getDocumentBase());
    $this->assertNull($certificate->getWhyChange());
    $this->assertNull($certificate->getSchemaCertificate());
    $this->assertNull($certificate->getDescription());
    $this->assertNull($certificate->getLinkOut());

    $certificate->mr_delete();
    $certificate->flush();

    $this->assertNull(MrCertificate::loadBy($certificate_id));
  }
}