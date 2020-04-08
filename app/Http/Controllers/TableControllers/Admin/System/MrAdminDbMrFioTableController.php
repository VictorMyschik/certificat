<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrFio;

class MrAdminDbMrFioTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrFio::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'ObjectKind', 'sort' => 'ObjectKind'),
        array('name' => 'ObjectID', 'sort' => 'ObjectID'),
        array('name' => 'FirstName', 'sort' => 'FirstName'),
        array('name' => 'MiddleName', 'sort' => 'MiddleName'),
        array('name' => 'LastName', 'sort' => 'LastName'),
      ),

      'body' => $body
    );
  }
}