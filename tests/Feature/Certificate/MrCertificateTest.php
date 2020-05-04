<?php

namespace Tests\Feature\Certificate;

use App\Helpers\MrDateTime;
use App\Models\Certificate\MrApplicant;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use App\Models\References\MrTechnicalRegulation;
use Tests\TestCase;

class MrCertificateTest extends TestCase
{
  public function testCertificate()
  {
    /**
     * 'CertificateKindID',// $table->integer('Kind');//Тип документа
     * 'Number',// $table->string('Number');//Регистрационный номер документа
     * 'DateFrom',// $table->date('DateFrom');//Дата начала срока действия
     * 'DateTo',// $table->date('DateTo')->nullable();//Дата окончания срока действия
     * 'CountryID',// $table->integer('CountryID');//Страна
     * 'Status',// $table->tinyInteger('Status')->default(0);//Статус действия | Действует
     * 'AuditorID',// $table->string('Auditor', 80);//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
     * 'BlankNumber',// $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
     * 'DateStatusFrom',// $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
     * 'DateStatusTo',// $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
     * 'DocumentBase',// $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
     * 'WhyChange',// $table->string('WhyChange')->nullable();//Причина изменения статуса
     * 'SchemaCertificate',// $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
     * 'Description',// $table->string('Description', 1000)->nullable();//Примечание для себя
     * 'LinkOut',// $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат
     * 'AuthorityID',//Сведения об органе по оценке соответствия
     * 'DateUpdateEAES',// Дата обновления на ЕАЭС
     * 'SingleListProductIndicator', //признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о соответствии по единой форме: 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
     *
     * 'ManufacturerID', // Производитель
     * 'ApplicantID',
     * 'TechnicalRegulationKindID'// Кодовое обозначение вида объекта технического регулирования
     */

    $certificate = new MrCertificate();
    //'Kind'
    $kind = self::randomIDfromClass(MrCertificateKind::class);
    $certificate->setCertificateKindID($kind);
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
    $Auditor = self::randomIDfromClass(MrFio::class);
    $certificate->setAuditorID($Auditor);
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
    //'AuthorityID'
    $AuthorityID = self::randomIDfromClass(MrConformityAuthority::class);
    $certificate->setAuthorityID($AuthorityID);
    //'DateUpdateEAES'
    $DateUpdateEAES = MrDateTime::now();
    $certificate->setDateUpdateEAES($DateUpdateEAES);
    //'SingleListProductIndicator'
    $SingleListProductIndicator = true;
    $certificate->setSingleListProductIndicator($SingleListProductIndicator);
    //'ManufacturerID'
    $ManufacturerID = self::randomIDfromClass(MrManufacturer::class);
    $certificate->setManufacturerID($ManufacturerID);
    //'ApplicantID'
    $ApplicantID = self::randomIDfromClass(MrApplicant::class);
    $certificate->setApplicantID($ApplicantID);
    //'TechnicalRegulationKindID'
    $TechnicalRegulationKindID = self::randomIDfromClass(MrTechnicalRegulation::class);
    $certificate->setTechnicalRegulationKindID($TechnicalRegulationKindID);


    $certificate_id = $certificate->save_mr();
    $certificate->flush();


    //// Asserts
    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);
    $this->assertEquals($certificate->getCertificateKind()->id(), $kind);
    $this->assertEquals($certificate->getNumber(), $Number);
    $this->assertEquals($certificate->getDateFrom()->getShortDate(), $DateFrom->getShortDate());
    $this->assertEquals($certificate->getDateTo()->getShortDate(), $DateTo->getShortDate());
    $this->assertEquals($certificate->getCountry()->id(), $CountryID);
    $this->assertEquals($certificate->getStatus(), $Status);
    $this->assertEquals($certificate->getAuditor()->id(), $Auditor);
    $this->assertEquals($certificate->getBlankNumber(), $BlankNumber);
    $this->assertEquals($certificate->getDateStatusFrom()->getShortDate(), $DateStatusFrom->getShortDate());
    $this->assertEquals($certificate->getDateStatusTo()->getShortDate(), $DateStatusTo->getShortDate());
    $this->assertEquals($certificate->getDocumentBase(), $DocumentBase);
    $this->assertEquals($certificate->getWhyChange(), $WhyChange);
    $this->assertEquals($certificate->getSchemaCertificate(), $SchemaCertificate);
    $this->assertEquals($certificate->getDescription(), $Description);
    $this->assertEquals($certificate->getLinkOut(), $LinkOut);
    $this->assertEquals($certificate->getAuthority()->id(), $AuthorityID);
    $this->assertEquals($certificate->getDateUpdateEAES()->getShortDate(), $DateUpdateEAES->getShortDate());
    $this->assertTrue($certificate->getSingleListProductIndicator());
    $this->assertEquals($certificate->getManufacturer()->id(), $ManufacturerID);
    $this->assertEquals($certificate->getApplicant()->id(), $ApplicantID);
    $this->assertEquals($certificate->getTechnicalRegulationKind()->id(), $TechnicalRegulationKindID);


    //// Update
    //'Kind'
    $kind = self::randomIDfromClass(MrCertificateKind::class);
    $certificate->setCertificateKindID($kind);
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
    $Auditor = self::randomIDfromClass(MrFio::class);
    $certificate->setAuditorID($Auditor);
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
    //'AuthorityID'
    $AuthorityID = self::randomIDfromClass(MrConformityAuthority::class);
    $certificate->setAuthorityID($AuthorityID);
    //'DateUpdateEAES'
    $DateUpdateEAES = MrDateTime::now();
    $certificate->setDateUpdateEAES($DateUpdateEAES);
    //'SingleListProductIndicator'
    $SingleListProductIndicator = false;
    $certificate->setSingleListProductIndicator($SingleListProductIndicator);
    //'ManufacturerID'
    $ManufacturerID = self::randomIDfromClass(MrManufacturer::class);
    $certificate->setManufacturerID($ManufacturerID);
    //'ApplicantID'
    $ApplicantID = self::randomIDfromClass(MrApplicant::class);
    $certificate->setApplicantID($ApplicantID);
    //'TechnicalRegulationKindID'
    $TechnicalRegulationKindID = self::randomIDfromClass(MrTechnicalRegulation::class);
    $certificate->setTechnicalRegulationKindID($TechnicalRegulationKindID);


    $certificate_id = $certificate->save_mr();
    $certificate->flush();


    //// Asserts
    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);
    $this->assertEquals($certificate->getCertificateKind()->id(), $kind);
    $this->assertEquals($certificate->getNumber(), $Number);
    $this->assertEquals($certificate->getDateFrom()->getShortDate(), $DateFrom->getShortDate());
    $this->assertEquals($certificate->getDateTo()->getShortDate(), $DateTo->getShortDate());
    $this->assertEquals($certificate->getCountry()->id(), $CountryID);
    $this->assertEquals($certificate->getStatus(), $Status);
    $this->assertEquals($certificate->getAuditor()->id(), $Auditor);
    $this->assertEquals($certificate->getBlankNumber(), $BlankNumber);
    $this->assertEquals($certificate->getDateStatusFrom()->getShortDate(), $DateStatusFrom->getShortDate());
    $this->assertEquals($certificate->getDateStatusTo()->getShortDate(), $DateStatusTo->getShortDate());
    $this->assertEquals($certificate->getDocumentBase(), $DocumentBase);
    $this->assertEquals($certificate->getWhyChange(), $WhyChange);
    $this->assertEquals($certificate->getSchemaCertificate(), $SchemaCertificate);
    $this->assertEquals($certificate->getDescription(), $Description);
    $this->assertEquals($certificate->getLinkOut(), $LinkOut);
    $this->assertEquals($certificate->getAuthority()->id(), $AuthorityID);
    $this->assertEquals($certificate->getDateUpdateEAES()->getShortDate(), $DateUpdateEAES->getShortDate());
    $this->assertFalse($certificate->getSingleListProductIndicator());
    $this->assertEquals($certificate->getManufacturer()->id(), $ManufacturerID);
    $this->assertEquals($certificate->getApplicant()->id(), $ApplicantID);
    $this->assertEquals($certificate->getTechnicalRegulationKind()->id(), $TechnicalRegulationKindID);


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

    $certificate->setAuthorityID(null);
    $certificate->setDateUpdateEAES(null);
    $certificate->setSingleListProductIndicator(false);
    $certificate->setManufacturerID(null);
    $certificate->setApplicantID(null);
    $certificate->setTechnicalRegulationKindID(null);

    $certificate_id = $certificate->save_mr();
    $certificate->flush();


    //// Asserts
    $certificate = MrCertificate::loadBy($certificate_id);
    $this->assertNotNull($certificate);

    $this->assertNull($certificate->getDateTo());
    $this->assertNull($certificate->getBlankNumber());
    $this->assertNull($certificate->getDateStatusFrom());
    $this->assertNull($certificate->getDateStatusTo());
    $this->assertNull($certificate->getDocumentBase());
    $this->assertNull($certificate->getWhyChange());
    $this->assertNull($certificate->getSchemaCertificate());
    $this->assertNull($certificate->getDescription());
    $this->assertNull($certificate->getLinkOut());
    $this->assertNull($certificate->getAuthority());
    $this->assertNull($certificate->getDateUpdateEAES());
    $this->assertFalse($certificate->getSingleListProductIndicator());
    $this->assertNull($certificate->getManufacturer());
    $this->assertNull($certificate->getApplicant());
    $this->assertNull($certificate->getTechnicalRegulationKind());

    // Delete
    $certificate->mr_delete();
    $certificate->flush();

    $this->assertNull(MrCertificate::loadBy($certificate_id));
  }
}