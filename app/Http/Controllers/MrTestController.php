<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;
use App\Models\Certificate\MrCertificate;

class MrTestController extends Controller
{
  public function index()
  {
    //dd(MrCertificate::loadBy(4));

    /*
        MrCertificate::AllDelete();
        MrCertificateDocument::AllDelete();
        MrCommunicate::AllDelete();
        MrCommunicateInTable::AllDelete();
        MrDocument::AllDelete();
        MrManufacturer::AllDelete();
        MrAddress::AllDelete();
        MrFio::AllDelete();
        MrApplicant::AllDelete();
        MrProductInfo::AllDelete();
        MrProduct::AllDelete();*/

    $this->qwe();
  }

  /**
   * считывание папки и парсинг всех файлов
   */
  public function qwe()
  {
    ini_set('max_execution_time', 500000);
    $files = scandir('files');

    // удаление шлака
    foreach ($files as $key => $file_q)
    {
      if(strlen($file_q) < 3)
      {
        unset($files[$key]);
      }
    }

    // перебор всех файлов
    foreach ($files as $key => $file_name)
    {
      if($file_name == '10000.xml'
        || $file_name == '100000.xml'
        || $file_name == '1000000.xml'
        || $file_name == '1005000.xml'
        || $file_name == '1010000.xml'
      )
      {
        continue;
      }

      $file = public_path() . '/files/' . $file_name;

      $xml = simplexml_load_file($file);

      MrXmlImportBase::parse($xml);

      $str = 'File: ' . $file_name;
      print_r(count(MrCertificate::$hashed));
      print_r($str);
      dd(1);
    }
  }
}