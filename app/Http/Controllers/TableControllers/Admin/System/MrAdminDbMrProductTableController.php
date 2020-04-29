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
        array('name' => 'CertificateID', 'sort' => 'CertificateID'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Tnved', 'sort' => 'Tnved'),
      ),

      'body' => $body
    );
  }
}