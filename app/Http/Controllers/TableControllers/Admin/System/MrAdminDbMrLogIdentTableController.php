<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrLogIdent;

class MrAdminDbMrLogIdentTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrLogIdent::Select(['*'])->paginate($on_page);

    return array(
        'header' => array(
            array('name' => 'id', 'sort' => 'id'),
            array('name' => 'Date', 'sort' => 'Date'),
            array('name' => 'Referer', 'sort' => 'Referer'),
            array('name' => 'Link', 'sort' => 'Link'),
            array('name' => 'Ip', 'sort' => 'Ip'),
            array('name' => 'UserID', 'sort' => 'UserID'),
            array('name' => 'UserAgent', 'sort' => 'UserAgent'),
            array('name' => 'City', 'sort' => 'City'),
            array('name' => 'Country', 'sort' => 'Country'),
            array('name' => 'Cookie', 'sort' => 'Cookie'),
            array('name' => 'LanguageID', 'sort' => 'LanguageID'),
        ),

        'body' => $body
    );
  }
}