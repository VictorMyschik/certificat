<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;

class MrAdminDbMrUserTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrUser::Select(['*'])->paginate($on_page);

    return array(
        'header' => array(
            array('name' => 'id', 'sort' => 'id'),
            array('name' => 'UserLaravelID', 'sort' => 'UserLaravelID'),
            array('name' => 'DateFirstVisit', 'sort' => 'DateFirstVisit'),
            array('name' => 'DateLogin', 'sort' => 'DateLogin'),
            array('name' => 'DateLastVisit', 'sort' => 'DateLastVisit'),
        ),

        'body' => $body
    );
  }
}