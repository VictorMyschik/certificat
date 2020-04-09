<?php


namespace Tests\Feature\Office;


use App\Models\MrOffice;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrOfficeTest extends TestCase
{
  public function testMrOffice()
  {
    /**
     * 'Name',
     * 'Description',
     *
     * 'UNP',
     * 'CountryID',
     * 'Email',
     * 'Phone',
     * // для свзяи и отправки почты
     * 'POPostalCode',
     * 'PORegion',
     * 'POCity',
     * 'POAddress',
     * // Юр. данные
     * 'URPostalCode',
     * 'URRegion',
     * 'URCity',
     * 'URAddress',
     * // Банковские данные
     * 'BankRS',
     * 'BankName',
     * 'BankCode',
     * 'BankAddress',
     * 'PersonSign',
     * 'PersonPost',
     * 'PersonFIO',
     * //'CreateDate'
     */

    $office = new MrOffice();
    //'Name',
    $Name = $this->randomString(255);
    $office->setName($Name);
    //'Description',
    $Description = $this->randomString(255);
    $office->setDescription($Description);
    //

    //'UNP',
    $UNP = $this->randomString(10);
    $office->setUNP($UNP);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $office->setCountryID($CountryID);
    //'Email',
    $Email = $this->randomString(50);
    $office->setEmail($Email);
    //'Phone',
    $Phone = $this->randomString(16);
    $office->setPhone($Phone);
    //// для свзяи и отправки почты

    //'POPostalCode',
    $POPostalCode = $this->randomString(50);
    $office->setPOPostalCode($POPostalCode);
    //'PORegion',
    $PORegion = $this->randomString(50);
    $office->setPORegion($PORegion);
    //'POCity',
    $POCity = $this->randomString(50);
    $office->setPOCity($POCity);
    //'POAddress',
    $POAddress = $this->randomString(500);
    $office->setPOAddress($POAddress);
    //// Юр. данные

    //'URPostalCode',
    $URPostalCode = $this->randomString(50);
    $office->setURPostalCode($URPostalCode);
    //'URRegion',
    $URRegion = $this->randomString(50);
    $office->setURRegion($URRegion);
    //'URCity',
    $URCity = $this->randomString(50);
    $office->setURCity($URCity);
    //'URAddress',
    $URAddress = $this->randomString(500);
    $office->setURAddress($URAddress);
    //// Банковские данные

    //'BankRS',
    $BankRS = $this->randomString(250);
    $office->setBankRS($BankRS);
    //'BankName',
    $BankName = $this->randomString(250);
    $office->setBankName($BankName);
    //'BankCode',
    $BankCode = $this->randomString(250);
    $office->setBankCode($BankCode);
    //'BankAddress',
    $BankAddress = $this->randomString(500);
    $office->setBankAddress($BankAddress);
    //'PersonSign',
    $PersonSign = $this->randomString(250);
    $office->setPersonSign($PersonSign);
    //'PersonPost',
    $PersonPost = $this->randomString(250);
    $office->setPersonPost($PersonPost);
    //'PersonFIO',
    $PersonFIO = $this->randomString(250);
    $office->setPersonFIO($PersonFIO);

    $office_id = $office->save_mr();
    $office->flush();


    //// Asserts
    $office = MrOffice::loadBy($office_id);
    $this->assertNotNull($office);

    $this->assertEquals($Name, $office->getName());
    $this->assertEquals($Description, $office->getDescription());
    $this->assertEquals($UNP, $office->getUNP());
    $this->assertEquals($CountryID, $office->getCountry()->id());
    $this->assertEquals($Email, $office->getEmail());
    $this->assertEquals($Phone, $office->getPhone());
    $this->assertEquals($POPostalCode, $office->getPOPostalCode());
    $this->assertEquals($PORegion, $office->getPORegion());
    $this->assertEquals($POCity, $office->getPOCity());
    $this->assertEquals($POAddress, $office->getPOAddress());
    $this->assertEquals($URPostalCode, $office->getURPostalCode());
    $this->assertEquals($URRegion, $office->getURRegion());
    $this->assertEquals($URCity, $office->getURCity());
    $this->assertEquals($BankRS, $office->getBankRS());
    $this->assertEquals($BankName, $office->getBankName());
    $this->assertEquals($BankCode, $office->getBankCode());
    $this->assertEquals($BankAddress, $office->getBankAddress());
    $this->assertEquals($PersonSign, $office->getPersonSign());
    $this->assertEquals($PersonPost, $office->getPersonPost());
    $this->assertEquals($PersonFIO, $office->getPersonFIO());


    //// Update
    //'Name',
    $Name = $this->randomString(255);
    $office->setName($Name);
    //'Description',
    $Description = $this->randomString(255);
    $office->setDescription($Description);
    //

    //'UNP',
    $UNP = $this->randomString(10);
    $office->setUNP($UNP);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $office->setCountryID($CountryID);
    //'Email',
    $Email = $this->randomString(50);
    $office->setEmail($Email);
    //'Phone',
    $Phone = $this->randomString(16);
    $office->setPhone($Phone);
    //// для свзяи и отправки почты

    //'POPostalCode',
    $POPostalCode = $this->randomString(50);
    $office->setPOPostalCode($POPostalCode);
    //'PORegion',
    $PORegion = $this->randomString(50);
    $office->setPORegion($PORegion);
    //'POCity',
    $POCity = $this->randomString(50);
    $office->setPOCity($POCity);
    //'POAddress',
    $POAddress = $this->randomString(500);
    $office->setPOAddress($POAddress);
    //// Юр. данные

    //'URPostalCode',
    $URPostalCode = $this->randomString(50);
    $office->setURPostalCode($URPostalCode);
    //'URRegion',
    $URRegion = $this->randomString(50);
    $office->setURRegion($URRegion);
    //'URCity',
    $URCity = $this->randomString(50);
    $office->setURCity($URCity);
    //'URAddress',
    $URAddress = $this->randomString(500);
    $office->setURAddress($URAddress);
    //// Банковские данные

    //'BankRS',
    $BankRS = $this->randomString(250);
    $office->setBankRS($BankRS);
    //'BankName',
    $BankName = $this->randomString(250);
    $office->setBankName($BankName);
    //'BankCode',
    $BankCode = $this->randomString(250);
    $office->setBankCode($BankCode);
    //'BankAddress',
    $BankAddress = $this->randomString(500);
    $office->setBankAddress($BankAddress);
    //'PersonSign',
    $PersonSign = $this->randomString(250);
    $office->setPersonSign($PersonSign);
    //'PersonPost',
    $PersonPost = $this->randomString(250);
    $office->setPersonPost($PersonPost);
    //'PersonFIO',
    $PersonFIO = $this->randomString(250);
    $office->setPersonFIO($PersonFIO);

    $office_id = $office->save_mr();
    $office->flush();


    //// Asserts
    $office = MrOffice::loadBy($office_id);
    $this->assertNotNull($office);

    $this->assertEquals($Name, $office->getName());
    $this->assertEquals($Description, $office->getDescription());
    $this->assertEquals($UNP, $office->getUNP());
    $this->assertEquals($CountryID, $office->getCountry()->id());
    $this->assertEquals($Email, $office->getEmail());
    $this->assertEquals($Phone, $office->getPhone());
    $this->assertEquals($POPostalCode, $office->getPOPostalCode());
    $this->assertEquals($PORegion, $office->getPORegion());
    $this->assertEquals($POCity, $office->getPOCity());
    $this->assertEquals($POAddress, $office->getPOAddress());
    $this->assertEquals($URPostalCode, $office->getURPostalCode());
    $this->assertEquals($URRegion, $office->getURRegion());
    $this->assertEquals($URCity, $office->getURCity());
    $this->assertEquals($BankRS, $office->getBankRS());
    $this->assertEquals($BankName, $office->getBankName());
    $this->assertEquals($BankCode, $office->getBankCode());
    $this->assertEquals($BankAddress, $office->getBankAddress());
    $this->assertEquals($PersonSign, $office->getPersonSign());
    $this->assertEquals($PersonPost, $office->getPersonPost());
    $this->assertEquals($PersonFIO, $office->getPersonFIO());


    //// NUll
    $office->setDescription(null);
    $office->setCountryID(null);
    $office->setEmail(null);
    $office->setPhone(null);
    $office->setPOPostalCode(null);
    $office->setPORegion(null);
    $office->setPOCity(null);
    $office->setPOAddress(null);
    $office->setURPostalCode(null);
    $office->setURRegion(null);
    $office->setURCity(null);
    $office->setURAddress(null);
    $office->setBankRS(null);
    $office->setBankName(null);
    $office->setBankCode(null);
    $office->setBankAddress(null);
    $office->setPersonSign(null);
    $office->setPersonPost(null);
    $office->setPersonFIO(null);

    $office_id = $office->save_mr();
    $office->flush();


    //// Asserts
    $office = MrOffice::loadBy($office_id);
    $this->assertNotNull($office);

    $this->assertNotNull($office->getName());
    $this->assertNull($office->getDescription());
    $this->assertNull($office->getCountry());
    $this->assertNull($office->getEmail());
    $this->assertNull($office->getPhone());
    $this->assertNull($office->getPOPostalCode());
    $this->assertNull($office->getPORegion());
    $this->assertNull($office->getPOCity());
    $this->assertNull($office->getPOAddress());
    $this->assertNull($office->getURPostalCode());
    $this->assertNull($office->getURRegion());
    $this->assertNull($office->getURCity());
    $this->assertNull($office->getURAddress());
    $this->assertNull($office->getBankRS());
    $this->assertNull($office->getBankName());
    $this->assertNull($office->getBankCode());
    $this->assertNull($office->getBankAddress());
    $this->assertNull($office->getPersonSign());
    $this->assertNull($office->getPersonPost());
    $this->assertNull($office->getPersonFIO());


    //// Delete
    $office->mr_delete();
    $office->flush();

    $this->assertNull(MrOffice::loadBy($office_id));
  }
}