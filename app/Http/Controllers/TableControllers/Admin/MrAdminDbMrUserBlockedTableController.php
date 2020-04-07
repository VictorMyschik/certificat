<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrCommunicate;
use App\Models\MrLanguage;
use App\Models\MrUserBlocked;
use App\Models\MrUserInOffice;

class MrAdminDbMrUserBlockedTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrUserBlocked::Select()->paginate($on_page);

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