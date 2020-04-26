<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrDocument;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use App\Models\Lego\MrCertificateDocument;
use App\Models\Lego\MrCommunicateInTable;

class MrTestController extends Controller
{
  public function index()
  {
    dd(MrCertificate::loadBy(2)->getApplicant());


    MrCertificate::AllDelete();
    MrCertificateDocument::AllDelete();
    MrCommunicate::AllDelete();
    MrCommunicateInTable::AllDelete();
    MrDocument::AllDelete();
    MrManufacturer::AllDelete();
    MrAddress::AllDelete();
    MrFio::AllDelete();


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


      $file = public_path() . '/files/' . $file_name;

      $xml = simplexml_load_file($file);

      MrXmlImportBase::parse($xml);

      $str = 'File: ' . $file_name;
      print_r(count(MrCertificate::$hashed));
      print_r($str);

    }
  }
}