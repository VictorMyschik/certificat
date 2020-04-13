<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCertificateMonitoring;

class MrAdminDbMrCertificateMonitoringTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrCertificateMonitoring::Select(['*'])->paginate($on_page);

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