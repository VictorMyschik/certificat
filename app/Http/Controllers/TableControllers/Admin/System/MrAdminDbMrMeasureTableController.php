<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\References\MrMeasure;

class MrAdminDbMrMeasureTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrMeasure::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Code', 'sort' => 'Code'),
        array('name' => 'TextCode', 'sort' => 'TextCode'),
        array('name' => 'Name', 'sort' => 'Name'),
      ),

      'body' => $body
    );
  }
}