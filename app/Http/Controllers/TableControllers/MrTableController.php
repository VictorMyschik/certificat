<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Controller;

class MrTableController extends Controller
{
  public static function renderTable($header, $rows, $list)
  {
    $rows_out = array();

    foreach ($rows as $row)
    {
      foreach ($row as $key => $cell)
      {
        if(is_array($cell))
        {
          $row[$key] = View('layouts.Elements.mr_array_render', ['a' => $cell]);
        }
      }

      $rows_out[] = $row;
    }

    $list = array(
      '#header' => $header,
      '#rows' => $rows_out,
      '#links' => $list['links']
    );

    return View('layouts.Elements.table', ['table' => $list]);
  }
}