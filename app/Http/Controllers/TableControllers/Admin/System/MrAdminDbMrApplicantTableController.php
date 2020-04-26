<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrApplicant;

class MrAdminDbMrApplicantTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrApplicant::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Address1ID', 'sort' => 'Address1ID'),
        array('name' => 'Address2ID', 'sort' => 'Address2ID'),
        array('name' => 'FioID', 'sort' => 'FioID'),
        array('name' => 'Hash', 'sort' => 'Hash'),
      ),

      'body' => $body
    );
  }
}