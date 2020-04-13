<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUserInOffice;

class MrAdminDbMrUserInOfficeTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrUserInOffice::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'UserID', 'sort' => 'UserID'),
        array('name' => 'OfficeID', 'sort' => 'OfficeID'),
        array('name' => 'IsAdmin', 'sort' => 'IsAdmin'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}