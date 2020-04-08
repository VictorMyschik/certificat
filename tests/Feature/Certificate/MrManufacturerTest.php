<?php


namespace Tests\Feature\Certificate;


use App\Models\Certificate\MrManufacturer;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrManufacturerTest extends TestCase
{
  public function testMrManufacturer()
  {
    // 'CountryID',
    // 'Name',

    $manufacturer = new MrManufacturer();

    // 'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $manufacturer->setCountryID($CountryID);
    // 'Name',
    $Name = $this->randomString(255);
    $manufacturer->setName($Name);

    $manufacturer_id = $manufacturer->save_mr();
    $manufacturer->flush();

    //// Asserts
    $manufacturer = MrManufacturer::loadBy($manufacturer_id);
    $this->assertNotNull($manufacturer);

    $this->assertEquals($manufacturer->getCountry()->id(), $CountryID);
    $this->assertEquals($manufacturer->getName(), $Name);


    //// Update
    // 'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $manufacturer->setCountryID($CountryID);
    // 'Name',
    $Name = $this->randomString(255);
    $manufacturer->setName($Name);

    $manufacturer_id = $manufacturer->save_mr();
    $manufacturer->flush();

    //// Asserts
    $manufacturer = MrManufacturer::loadBy($manufacturer_id);
    $this->assertNotNull($manufacturer);

    $this->assertEquals($manufacturer->getCountry()->id(), $CountryID);
    $this->assertEquals($manufacturer->getName(), $Name);

    //// Delete
    $manufacturer->mr_delete();
    $manufacturer->flush();

    $this->assertNull(MrManufacturer::loadBy($manufacturer_id));
  }
}