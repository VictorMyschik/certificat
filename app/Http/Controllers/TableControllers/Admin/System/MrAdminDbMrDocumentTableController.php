<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrDocument;

class MrAdminDbMrDocumentTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrDocument::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Kind', 'sort' => 'Kind'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Number', 'sort' => 'Number'),
        array('name' => 'Date', 'sort' => 'Date'),
        array('name' => 'DateFrom', 'sort' => 'DateFrom'),
        array('name' => 'DateTo', 'sort' => 'DateTo'),
        array('name' => 'Organisation', 'sort' => 'Organisation'),
        array('name' => 'Description', 'sort' => 'Description'),
        array('name' => 'IsInclude', 'sort' => 'IsInclude'),
      ),

      'body' => $body
    );
  }
}