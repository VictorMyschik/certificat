<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrConformityAuthority;

class MrAdminDbMrConformityAuthorityTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrConformityAuthority::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'ConformityAuthorityId', 'sort' => 'ConformityAuthorityId'),
        array('name' => 'DocumentNumber', 'sort' => 'DocumentNumber'),
        array('name' => 'DocumentDate', 'sort' => 'DocumentDate'),
        array('name' => 'OfficerDetailsID', 'sort' => 'OfficerDetailsID'),
        array('name' => 'AddressID', 'sort' => 'AddressID'),
      ),

      'body' => $body
    );
  }
}