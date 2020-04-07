<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrEmailLog;
use App\Models\MrLanguage;

class MrAdminDbMrEmailLogTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrEmailLog::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'UserID', 'sort' => 'UserID'),
        array('name' => 'Email', 'sort' => 'Email'),
        array('name' => 'Title', 'sort' => 'Title'),
        array('name' => 'Text', 'sort' => 'Text'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}