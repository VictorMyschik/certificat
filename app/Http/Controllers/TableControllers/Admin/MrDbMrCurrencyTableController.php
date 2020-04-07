<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\References\MrCurrency;

class MrDbMrCurrencyTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCurrency::Select()->paginate($on_page);

    return array(
      'header' => array(
        'id' => 'id',
        'Code' => 'Code',
        'TextCode' => 'TextCode',
        'DateFrom' => 'DateFrom',
        'DateTo' => 'DateTo',
        'Name' => 'Name',
        'Rounding' => 'Rounding',
        'Description' => 'Description',
      ),

      'body' => $body
    );
  }
}