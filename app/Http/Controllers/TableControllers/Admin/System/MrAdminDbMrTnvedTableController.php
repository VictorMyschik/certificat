<?php

namespace App\Http\Controllers\TableControllers\Admin\System;

use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrTnved;

class MrAdminDbMrTnvedTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrTnved::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Code', 'sort' => 'Code'),
        array('name' => 'Name', 'sort' => 'Name'),
      ),

      'body' => $body
    );
  }
}