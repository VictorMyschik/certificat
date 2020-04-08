<?php


namespace Tests\Feature\Certificate;


use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrManufacturer;
use App\Models\References\MrCountry;
use Tests\TestCase;

class MrAddressTest extends TestCase
{
  public function testMrAddress()
  {
    /*
    'ObjectKind',
    'ObjectID',
    'CountryID',
    'City',
    'Building',
    'Address',
    'Lat',
    'Lon',
    */
    $address = new MrAddress();
    self::assertNotNull($address);
    //'ObjectKind',
    $KindObject = MrAddress::KIND_OBJECT_MANUFACTURER;
    $address->setObjectKind($KindObject);
    //'ObjectID',
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $address->setObjectID($ObjectID);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $address->setCountryID($CountryID);
    //'City',
    $City = $this->randomString();
    $address->setCity($City);
    //'Building',
    $Building = $this->randomString();
    $address->setBuilding($Building);
    //'Address',
    $Address = $this->randomString();
    $address->setAddress($Address);
    //'Lat',
    $Lat = $this->randomString();
    $address->setLat($Lat);
    //'Lon',
    $Lon = $this->randomString();
    $address->setLon($Lon);

    $address_id = $address->save_mr();
    $address->flush();

    //// Asserts
    $address = MrAddress::loadBy($address_id);
    self::assertNotNull($address);
    $this->assertEquals($KindObject, $address->getObjectKind());
    $this->assertEquals($ObjectID, $address->getObject()->id());
    $this->assertEquals($CountryID, $address->getCountry()->id());
    $this->assertEquals($City, $address->getCity());
    $this->assertEquals($Building, $address->getBuilding());
    $this->assertEquals($Address, $address->getAddress());
    $this->assertEquals($Lat, $address->getLat());
    $this->assertEquals($Lon, $address->getLon());


    //// Update
    //'ObjectKind',
    $KindObject = MrAddress::KIND_OBJECT_MANUFACTURER;
    $address->setObjectKind($KindObject);
    //'ObjectID',
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $address->setObjectID($ObjectID);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $address->setCountryID($CountryID);
    //'City',
    $City = $this->randomString();
    $address->setCity($City);
    //'Building',
    $Building = $this->randomString();
    $address->setBuilding($Building);
    //'Address',
    $Address = $this->randomString();
    $address->setAddress($Address);
    //'Lat',
    $Lat = $this->randomString();
    $address->setLat($Lat);
    //'Lon',
    $Lon = $this->randomString();
    $address->setLon($Lon);

    $address_id = $address->save_mr();
    $address->flush();

    //// Asserts
    $address = MrAddress::loadBy($address_id);
    self::assertNotNull($address);
    $this->assertEquals($KindObject, $address->getObjectKind());
    $this->assertEquals($ObjectID, $address->getObject()->id());
    $this->assertEquals($CountryID, $address->getCountry()->id());
    $this->assertEquals($City, $address->getCity());
    $this->assertEquals($Building, $address->getBuilding());
    $this->assertEquals($Address, $address->getAddress());
    $this->assertEquals($Lat, $address->getLat());
    $this->assertEquals($Lon, $address->getLon());

    //// NUll
    //'City',
    $address->setCity(null);
    //'Building',
    $address->setBuilding(null);
    //'Address',
    $address->setAddress(null);
    //'Lat',
    $address->setLat(null);
    //'Lon',
    $address->setLon(null);

    $address_id = $address->save_mr();
    $address->flush();


    //// Asserts
    $this->assertNull($address->getCity());
    $this->assertNull($address->getBuilding());
    $this->assertNull($address->getAddress());
    $this->assertNull($address->getLat());
    $this->assertNull($address->getLon());

    // Delete
    $address->mr_delete();
    $address->flush();
    self::assertNull(MrAddress::loadBy($address_id));
  }
}