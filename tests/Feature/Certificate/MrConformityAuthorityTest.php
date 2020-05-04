<?php

namespace Tests\Feature\Certificate;

use App\Helpers\MrDateTime;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrConformityAuthorityTest extends TestCase
{
  public function testMrConformityAuthority()
  {
    /**
     * 'CountryID'
     * 'Name'
     * 'ConformityAuthorityId'
     * 'DocumentNumber'
     * 'DocumentDate'
     * 'Address1ID',//адрес регистрации
     * 'Address2ID',//фактический адрес
     */

    $authority = new MrConformityAuthority();
    // 'Name'
    $Name = $this->randomString(300);
    $authority->setName($Name);
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
    //Address1ID
    $Address1ID = self::randomIDfromClass(MrAddress::$className);
    $authority->setAddress1ID($Address1ID);
    //Address2ID
    $Address2ID = self::randomIDfromClass(MrAddress::$className);
    $authority->setAddress2ID($Address2ID);

    $authority_id = $authority->save_mr();
    $authority->flush();


    //// Asserts
    $authority = MrConformityAuthority::loadBy($authority_id);
    $this->assertNotNull($authority);
    $this->assertEquals($CountryID, $authority->getCountry()->id());
    $this->assertEquals($Name, $authority->getName());
    $this->assertEquals($DocumentNumber, $authority->getDocumentNumber());
    $this->assertEquals($DocumentDate->getShortDate(), $authority->getDocumentDate()->getShortDate());
    $this->assertEquals($OfficerDetailsID, $authority->getOfficerDetails()->id());
    $this->assertEquals($Address1ID, $authority->getAddress1()->id());
    $this->assertEquals($Address2ID, $authority->getAddress2()->id());


    //// Update
    // 'Name'
    $Name = $this->randomString(300);
    $authority->setName($Name);
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
    //Address1ID
    $Address1ID = self::randomIDfromClass(MrAddress::$className);
    $authority->setAddress1ID($Address1ID);
    //Address2ID
    $Address2ID = self::randomIDfromClass(MrAddress::$className);
    $authority->setAddress2ID($Address2ID);

    $authority_id = $authority->save_mr();
    $authority->flush();


    //// Asserts
    $authority = MrConformityAuthority::loadBy($authority_id);
    $this->assertNotNull($authority);
    $this->assertEquals($Name, $authority->getName());
    $this->assertEquals($CountryID, $authority->getCountry()->id());
    $this->assertEquals($DocumentNumber, $authority->getDocumentNumber());
    $this->assertEquals($DocumentDate->getShortDate(), $authority->getDocumentDate()->getShortDate());
    $this->assertEquals($OfficerDetailsID, $authority->getOfficerDetails()->id());
    $this->assertEquals($Address1ID, $authority->getAddress1()->id());
    $this->assertEquals($Address2ID, $authority->getAddress2()->id());


    //// Delete
    $authority->mr_delete();
    $authority->flush();

    $this->assertNull(MrConformityAuthority::loadBy($authority_id));
  }
}