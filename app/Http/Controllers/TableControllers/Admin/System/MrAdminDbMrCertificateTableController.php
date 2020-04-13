<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCertificate;

class MrAdminDbMrCertificateTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrCertificate::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Kind', 'sort' => 'Kind'),
        array('name' => 'Number', 'sort' => 'Number'),
        array('name' => 'DateFrom', 'sort' => 'DateFrom'),
        array('name' => 'DateTo', 'sort' => 'DateTo'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'Status', 'sort' => 'Status'),
        array('name' => 'Auditor', 'sort' => 'Auditor'),
        array('name' => 'BlankNumber', 'sort' => 'BlankNumber'),
        array('name' => 'DateStatusFrom', 'sort' => 'DateStatusFrom'),
        array('name' => 'DateStatusTo', 'sort' => 'DateStatusTo'),
        array('name' => 'DocumentBase', 'sort' => 'DocumentBase'),
        array('name' => 'WhyChange', 'sort' => 'WhyChange'),
        array('name' => 'SchemaCertificate', 'sort' => 'SchemaCertificate'),
        array('name' => 'Description', 'sort' => 'Description'),
        array('name' => 'LinkOut', 'sort' => 'LinkOut'),
        array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      ),

      'body' => $body
    );
  }
}