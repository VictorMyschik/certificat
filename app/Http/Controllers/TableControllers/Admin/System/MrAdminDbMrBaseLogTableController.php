<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;

class MrAdminDbMrBaseLogTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrBaseLog::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'LogIdentID', 'sort' => 'LogIdentID'),
        array('name' => 'TableName', 'sort' => 'TableName'),
        array('name' => 'RowId', 'sort' => 'RowId'),
        array('name' => 'Field', 'sort' => 'Field'),
        array('name' => 'Value', 'sort' => 'Value'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}