<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUsersBlocked;

class MrAdminDbMrUserBlockedTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrUsersBlocked::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'UserID', 'sort' => 'UserID'),
        array('name' => 'DateFrom', 'sort' => 'DateFrom'),
        array('name' => 'DateTo', 'sort' => 'DateTo'),
        array('name' => 'Description', 'sort' => 'Description'),
      ),

      'body' => $body
    );
  }
}