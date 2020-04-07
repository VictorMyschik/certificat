<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrLogIdent;

class MrAdminDbMrLogIdentTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrLogIdent::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Referer', 'sort' => 'Referer'),
        array('name' => 'Link', 'sort' => 'Link'),
        array('name' => 'Ip', 'sort' => 'Ip'),
        array('name' => 'UserID', 'sort' => 'UserID'),
        array('name' => 'UserAgent', 'sort' => 'UserAgent'),
        array('name' => 'City', 'sort' => 'City'),
      ),

      'body' => $body
    );
  }
}