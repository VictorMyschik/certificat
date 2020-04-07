<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;

class MrAdminDbMrUserTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrUser::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'UserLaravelID', 'sort' => 'UserLaravelID'),
        array('name' => 'Telegram', 'sort' => 'Telegram'),
        array('name' => 'DateFirstVisit', 'sort' => 'DateFirstVisit'),
        array('name' => 'DateLogin', 'sort' => 'DateLogin'),
        array('name' => 'DefaultOfficeID', 'sort' => 'DefaultOfficeID'),
        array('name' => 'DateLastVisit', 'sort' => 'DateLastVisit'),
        array('name' => 'Phone', 'sort' => 'Phone'),
      ),

      'body' => $body
    );
  }
}