<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrTranslate;

class MrAdminDbMrTranslateTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrTranslate::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'LanguageID', 'sort' => 'LanguageID'),
        array('name' => 'Translate', 'sort' => 'Translate'),
      ),

      'body' => $body
    );
  }
}