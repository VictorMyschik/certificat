<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCommunicate;

class MrAdminDbMrCommunicateTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrCommunicate::Select(['*'])->paginate($on_page);

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