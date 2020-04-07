<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrFaq;

class MrAdminDbMrFaqTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrFaq::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Title', 'sort' => 'Title'),
        array('name' => 'Text', 'sort' => 'Text'),
      ),

      'body' => $body
    );
  }
}