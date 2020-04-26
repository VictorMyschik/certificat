<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Lego\MrCertificateDocument;

class MrAdminDbMrCertificateDocumentTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrCertificateDocument::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'CertificateID', 'sort' => 'CertificateID'),
        array('name' => 'DocumentID', 'sort' => 'DocumentID'),
      ),

      'body' => $body
    );
  }
}