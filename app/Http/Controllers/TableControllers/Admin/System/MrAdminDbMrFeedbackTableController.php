<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrFeedback;

class MrAdminDbMrFeedbackTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrFeedback::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Email', 'sort' => 'Email'),
        array('name' => 'Text', 'sort' => 'Text'),
        array('name' => 'Date', 'sort' => 'Date'),
      ),

      'body' => $body
    );
  }
}