<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrProduct;

class MrAdminDbMrProductTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrProduct::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'ManufacturerID', 'sort' => 'ManufacturerID'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'EANCommodityId', 'sort' => 'EANCommodityId'),
        array('name' => 'TnvedID', 'sort' => 'TnvedID'),
      ),

      'body' => $body
    );
  }
}