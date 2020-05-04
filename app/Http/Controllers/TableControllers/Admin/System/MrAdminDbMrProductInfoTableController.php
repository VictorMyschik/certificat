<?php

namespace App\Http\Controllers\TableControllers\Admin\System;

use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrProductInfo;

class MrAdminDbMrProductInfoTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrProductInfo::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'ProductID', 'sort' => 'ProductID'),
        array('name' => 'MeasureID', 'sort' => 'MeasureID'),
        array('name' => 'InstanceId', 'sort' => 'InstanceId'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Description', 'sort' => 'Description'),
        array('name' => 'ManufacturedDate', 'sort' => 'ManufacturedDate'),
        array('name' => 'ExpiryDate', 'sort' => 'ExpiryDate'),
        array('name' => 'TnvedID', 'sort' => 'TnvedID'),
      ),

      'body' => $body
    );
  }
}