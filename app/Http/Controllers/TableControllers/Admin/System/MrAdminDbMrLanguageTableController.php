<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrLanguage;

class MrAdminDbMrLanguageTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrLanguage::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Description', 'sort' => 'Description'),
      ),

      'body' => $body
    );
  }
}