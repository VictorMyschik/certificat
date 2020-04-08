<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrAddress;

class MrAdminDbMrAddressTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrAddress::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'ObjectKind', 'sort' => 'ObjectKind'),
        array('name' => 'ObjectID', 'sort' => 'ObjectID'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'City', 'sort' => 'City'),
        array('name' => 'Building', 'sort' => 'Building'),
        array('name' => 'Address', 'sort' => 'Address'),
        array('name' => 'Lat', 'sort' => 'Lat'),
        array('name' => 'Lon', 'sort' => 'Lon'),
      ),

      'body' => $body
    );
  }
}