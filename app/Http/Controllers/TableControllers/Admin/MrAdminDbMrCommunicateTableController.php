<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrCommunicate;
use App\Models\MrLanguage;

class MrAdminDbMrCommunicateTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCommunicate::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'KindObject', 'sort' => 'KindObject'),
        array('name' => 'ObjectID', 'sort' => 'ObjectID'),
        array('name' => 'Kind', 'sort' => 'Kind'),
        array('name' => 'Address', 'sort' => 'Address'),
      ),

      'body' => $body
    );
  }
}