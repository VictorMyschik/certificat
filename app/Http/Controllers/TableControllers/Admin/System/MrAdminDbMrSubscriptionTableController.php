<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrSubscription;

class MrAdminDbMrSubscriptionTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrSubscription::Select(['*'])->paginate($on_page);

    return array(
        'header' => array(
            array('name' => 'id', 'sort' => 'id'),
            array('name' => 'Email', 'sort' => 'Email'),
            array('name' => 'Date', 'sort' => 'Date'),
            array('name' => 'Token', 'sort' => 'Token'),
        ),

        'body' => $body
    );
  }
}