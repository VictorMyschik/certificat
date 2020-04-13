<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrNewUsers;

class MrAdminDbMrNewUsersTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrNewUsers::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Email', 'sort' => 'Email'),
        array('name' => 'Code', 'sort' => 'Code'),
        array('name' => 'UserID', 'sort' => 'UserID'),
        array('name' => 'ChecklistID', 'sort' => 'ChecklistID'),
        array('name' => 'IsAdmin', 'sort' => 'IsAdmin'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}