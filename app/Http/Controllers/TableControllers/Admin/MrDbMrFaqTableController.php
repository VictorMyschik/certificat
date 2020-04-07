<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrFaq;

class MrDbMrFaqTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrFaq::Select()->paginate($on_page);

    return array(
      'header' => array(
        'id' => 'id',
        'Title' => 'Title',
        'Text' => 'Text',
      ),

      'body' => $body
    );
  }
}