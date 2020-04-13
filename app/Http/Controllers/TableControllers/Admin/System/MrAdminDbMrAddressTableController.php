<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrAddress;

class MrAdminDbMrAddressTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrAddress::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'ObjectKind', 'sort' => 'ObjectKind'),
        array('name' => 'ObjectID', 'sort' => 'ObjectID'),
        array('name' => 'AddressKind', 'sort' => 'AddressKind'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'TerritoryCode', 'sort' => 'TerritoryCode'),
        array('name' => 'RegionName', 'sort' => 'RegionName'),
        array('name' => 'DistrictName', 'sort' => 'DistrictName'),
        array('name' => 'City', 'sort' => 'City'),
        array('name' => 'SettlementName', 'sort' => 'SettlementName'),
        array('name' => 'StreetName', 'sort' => 'StreetName'),
        array('name' => 'BuildingNumberId', 'sort' => 'BuildingNumberId'),
        array('name' => 'RoomNumberId', 'sort' => 'RoomNumberId'),
        array('name' => 'PostCode', 'sort' => 'PostCode'),
        array('name' => 'PostOfficeBoxId', 'sort' => 'PostOfficeBoxId'),
        array('name' => 'AddressText', 'sort' => 'AddressText'),
        array('name' => 'Lat', 'sort' => 'Lat'),
        array('name' => 'Lon', 'sort' => 'Lon'),
      ),

      'body' => $body
    );
  }
}