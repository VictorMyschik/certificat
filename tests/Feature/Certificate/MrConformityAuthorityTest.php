<?php


namespace Tests\Feature\Certificate;


use App\Helpers\MrDateTime;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrConformityAuthorityTest extends TestCase
{
  public function testMrConformityAuthority()
  {
    /**
     * 'ConformityAuthorityId',//номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
     * 'CountryID', // кодовое обозначение страны, в которой зарегистрирован орган по оценке соответствия
     * 'DocumentNumber', // номер документа, подтверждающего аккредитацию органа по оценке соответствия
     * 'DocumentDate', // дата регистрации документа подтверждающего аккредитацию органа по оценке соответствия
     * 'OfficerDetailsID',// Руководитель органа по оценке соответствия
     */

    $authority = new MrConformityAuthority();
    //'ConformityAuthorityId'
    $ConformityAuthorityId = $this->randomString(40);
    $authority->setConformityAuthorityId($ConformityAuthorityId);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $authority->setCountryID($CountryID);
    //'DocumentNumber'
    $DocumentNumber = $this->randomString(50);
    $authority->setDocumentNumber($DocumentNumber);
    //'DocumentDate'
    $DocumentDate = MrDateTime::now();
    $authority->setDocumentDate($DocumentDate);
    //'OfficerDetailsID'
    $OfficerDetailsID = self::randomIDfromClass(MrFio::class);
    $authority->setOfficerDetailsID($OfficerDetailsID);

    $authority_id = $authority->save_mr();
    $authority->flush();


    //// Asserts
    $authority = MrConformityAuthority::loadBy($authority_id);
    $this->assertNotNull($authority);
    $this->assertEquals($CountryID, $authority->getCountry()->id());
    $this->assertEquals($DocumentNumber, $authority->getDocumentNumber());
    $this->assertEquals($DocumentDate->getShortDate(), $authority->getDocumentDate()->getShortDate());
    $this->assertEquals($OfficerDetailsID, $authority->getOfficerDetails()->id());


    //// Update
    //'ConformityAuthorityId'
    $ConformityAuthorityId = $this->randomString(40);
    $authority->setConformityAuthorityId($ConformityAuthorityId);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $authority->setCountryID($CountryID);
    //'DocumentNumber'
    $DocumentNumber = $this->randomString(50);
    $authority->setDocumentNumber($DocumentNumber);
    //'DocumentDate'
    $DocumentDate = MrDateTime::now();
    $authority->setDocumentDate($DocumentDate);
    //'OfficerDetailsID'
    $OfficerDetailsID = self::randomIDfromClass(MrFio::class);
    $authority->setOfficerDetailsID($OfficerDetailsID);

    $authority_id = $authority->save_mr();
    $authority->flush();


    //// Asserts
    $authority = MrConformityAuthority::loadBy($authority_id);
    $this->assertNotNull($authority);
    $this->assertEquals($CountryID, $authority->getCountry()->id());
    $this->assertEquals($DocumentNumber, $authority->getDocumentNumber());
    $this->assertEquals($DocumentDate->getShortDate(), $authority->getDocumentDate()->getShortDate());
    $this->assertEquals($OfficerDetailsID, $authority->getOfficerDetails()->id());


    //// Delete
    $authority->mr_delete();
    $authority->flush();

    $this->assertNull(MrConformityAuthority::loadBy($authority_id));
  }
}