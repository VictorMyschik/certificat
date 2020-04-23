<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Lego\MrCommunicateInTable;

class MrAdminDbMrCommunicateInTableTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrCommunicateInTable::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'TableKind', 'sort' => 'TableKind'),
        array('name' => 'RowID', 'sort' => 'RowID'),
        array('name' => 'CommunicateID', 'sort' => 'CommunicateID'),
      ),

      'body' => $body
    );
  }
}