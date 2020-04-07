<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrCertificateMonitoring;
use App\Models\MrCommunicate;
use App\Models\MrLanguage;
use App\Models\MrNewUsers;

class MrAdminDbMrCertificateMonitoringTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCertificateMonitoring::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'UserInOfficeID', 'sort' => 'UserInOfficeID'),
        array('name' => 'CertificateID', 'sort' => 'CertificateID'),
        array('name' => 'Description', 'sort' => 'Description'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}