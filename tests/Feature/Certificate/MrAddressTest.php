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
    /**
     * 'ObjectKind',
     * 'ObjectID',
     * 'AddressKind',
     * 'CountryID',
     * 'TerritoryCode',//17
     * 'RegionName',//120
     * 'DistrictName',//120
     * 'City', //120
     * 'SettlementName', //120
     * 'StreetName', //120
     * 'BuildingNumberId',//50
     * 'RoomNumberId',//20
     * 'PostCode', //max 10
     * 'PostOfficeBoxId', //max 20
     * 'AddressText', //max 1000
     * 'Lat',
     * 'Lon',
     */

    $address = new MrAddress();
    self::assertNotNull($address);
    //'AddressKind'
    $AddressKind = array_rand(MrAddress::GetAddressKindList());
    $address->setAddressKind($AddressKind);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $address->setCountryID($CountryID);
    //'TerritoryCode'
    $TerritoryCode = $this->randomString(18);
    $address->setTerritoryCode($TerritoryCode);
    //'RegionName'
    $RegionName = $this->randomString(120);
    $address->setRegionName($RegionName);
    //'DistrictName'
    $DistrictName = $this->randomString(120);
    $address->setDistrictName($DistrictName);
    //'City',
    $City = $this->randomString(120);
    $address->setCity($City);
    //'SettlementName'
    $SettlementName = $this->randomString(120);
    $address->setSettlementName($SettlementName);
    //'StreetName',
    $StreetName = $this->randomString(120);
    $address->setStreetName($StreetName);
    //'BuildingNumberId',
    $BuildingNumberId = $this->randomString(50);
    $address->setBuildingNumberId($BuildingNumberId);
    //'RoomNumberId'
    $RoomNumberId = $this->randomString(20);
    $address->setRoomNumberId($RoomNumberId);
    //'PostCode'
    $PostCode = $this->randomString(10);
    $address->setPostCode($PostCode);
    //'PostOfficeBoxId'
    $PostOfficeBoxId = $this->randomString(20);
    $address->setPostOfficeBoxId($PostOfficeBoxId);
    //'AddressText'
    $AddressText = $this->randomString(1000);
    $address->setAddressText($AddressText);
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
    $this->assertEquals($AddressKind, $address->getAddressKind());
    $this->assertEquals($TerritoryCode, $address->getTerritoryCode());
    $this->assertEquals($RegionName, $address->getRegionName());
    $this->assertEquals($DistrictName, $address->getDistrictName());
    $this->assertEquals($CountryID, $address->getCountry()->id());
    $this->assertEquals($City, $address->getCity());
    $this->assertEquals($SettlementName, $address->getSettlementName());
    $this->assertEquals($StreetName, $address->getStreetName());
    $this->assertEquals($BuildingNumberId, $address->getBuildingNumberId());
    $this->assertEquals($RoomNumberId, $address->getRoomNumberId());
    $this->assertEquals($PostCode, $address->getPostCode());
    $this->assertEquals($PostOfficeBoxId, $address->getPostOfficeBoxId());
    $this->assertEquals($AddressText, $address->getAddressText());
    $this->assertEquals($Lat, $address->getLat());
    $this->assertEquals($Lon, $address->getLon());


    //// Update
    //'AddressKind'
    $AddressKind = array_rand(MrAddress::GetAddressKindList());
    $address->setAddressKind($AddressKind);
    //'CountryID',
    $CountryID = self::randomIDfromClass(MrCountry::class);
    $address->setCountryID($CountryID);
    //'TerritoryCode'
    $TerritoryCode = $this->randomString(18);
    $address->setTerritoryCode($TerritoryCode);
    //'RegionName'
    $RegionName = $this->randomString(120);
    $address->setRegionName($RegionName);
    //'DistrictName'
    $DistrictName = $this->randomString(120);
    $address->setDistrictName($DistrictName);
    //'City',
    $City = $this->randomString(120);
    $address->setCity($City);
    //'SettlementName'
    $SettlementName = $this->randomString(120);
    $address->setSettlementName($SettlementName);
    //'StreetName',
    $StreetName = $this->randomString(120);
    $address->setStreetName($StreetName);
    //'BuildingNumberId',
    $BuildingNumberId = $this->randomString(50);
    $address->setBuildingNumberId($BuildingNumberId);
    //'RoomNumberId'
    $RoomNumberId = $this->randomString(20);
    $address->setRoomNumberId($RoomNumberId);
    //'PostCode'
    $PostCode = $this->randomString(10);
    $address->setPostCode($PostCode);
    //'PostOfficeBoxId'
    $PostOfficeBoxId = $this->randomString(20);
    $address->setPostOfficeBoxId($PostOfficeBoxId);
    //'AddressText'
    $AddressText = $this->randomString(1000);
    $address->setAddressText($AddressText);
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
    $this->assertEquals($AddressKind, $address->getAddressKind());
    $this->assertEquals($TerritoryCode, $address->getTerritoryCode());
    $this->assertEquals($RegionName, $address->getRegionName());
    $this->assertEquals($DistrictName, $address->getDistrictName());
    $this->assertEquals($CountryID, $address->getCountry()->id());
    $this->assertEquals($City, $address->getCity());
    $this->assertEquals($SettlementName, $address->getSettlementName());
    $this->assertEquals($StreetName, $address->getStreetName());
    $this->assertEquals($BuildingNumberId, $address->getBuildingNumberId());
    $this->assertEquals($RoomNumberId, $address->getRoomNumberId());
    $this->assertEquals($PostCode, $address->getPostCode());
    $this->assertEquals($PostOfficeBoxId, $address->getPostOfficeBoxId());
    $this->assertEquals($AddressText, $address->getAddressText());
    $this->assertEquals($Lat, $address->getLat());
    $this->assertEquals($Lon, $address->getLon());


    //// NUll
    $address->setRegionName(null);
    $address->setDistrictName(null);
    $address->setCity(null);
    $address->setSettlementName(null);
    $address->setStreetName(null);
    $address->setBuildingNumberId(null);
    $address->setRoomNumberId(null);
    $address->setPostCode(null);
    $address->setPostOfficeBoxId(null);
    $address->setAddressText(null);
    $address->setLat(null);
    $address->setLon(null);

    $address_id = $address->save_mr();
    $address->flush();


    //// Asserts
    $this->assertNull($address->getRegionName());
    $this->assertNull($address->getDistrictName());
    $this->assertNull($address->getCity());
    $this->assertNull($address->getSettlementName());
    $this->assertNull($address->getStreetName());
    $this->assertNull($address->getBuildingNumberId());
    $this->assertNull($address->getRoomNumberId());
    $this->assertNull($address->getPostCode());
    $this->assertNull($address->getPostOfficeBoxId());
    $this->assertNull($address->getAddressText());
    $this->assertNull($address->getLat());
    $this->assertNull($address->getLon());


    // Delete
    $address->mr_delete();
    $address->flush();
    self::assertNull(MrAddress::loadBy($address_id));
  }
}