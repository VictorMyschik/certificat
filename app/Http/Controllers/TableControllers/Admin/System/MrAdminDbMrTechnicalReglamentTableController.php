<?php

namespace App\Http\Controllers\TableControllers\Admin\System;

use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\References\MrTechnicalReglament;

class MrAdminDbMrTechnicalReglamentTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrTechnicalReglament::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Code', 'sort' => 'Code'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Link', 'sort' => 'Link'),
      ),

      'body' => $body
    );
  }
}