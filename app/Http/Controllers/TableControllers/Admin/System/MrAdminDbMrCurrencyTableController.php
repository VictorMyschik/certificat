<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\References\MrCurrency;

class MrAdminDbMrCurrencyTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCurrency::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Code', 'sort' => 'Code'),
        array('name' => 'TextCode', 'sort' => 'TextCode'),
        array('name' => 'DateFrom', 'sort' => 'DateFrom'),
        array('name' => 'DateTo', 'sort' => 'DateTo'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Rounding', 'sort' => 'Rounding'),
        array('name' => 'Description', 'sort' => 'Description'),
      ),

      'body' => $body
    );
  }
}