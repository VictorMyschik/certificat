<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrCommunicate;
use App\Models\MrLanguage;
use App\Models\MrSubscription;
use App\Models\MrUserInOffice;

class MrAdminDbMrSubscriptionTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrSubscription::Select()->paginate($on_page);

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