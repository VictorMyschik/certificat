<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;
use App\Models\Certificate\MrCertificate;

class MrTestController extends Controller
{
  public function index()
  {
    $this->qwe();
  }

  /**
   * считываение папки и парсинг всех файлов
   */
  public function qwe()
  {
    //ini_set('max_execution_time', 90000000000000);
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
      if($key < 15)
      {
        continue;
      }
      $file = public_path() . '/files/' . $file_name;

      $xml = simplexml_load_file($file);

      MrXmlImportBase::parse($xml);

      $str = 'File: ' . $file_name;
      print_r(count(MrCertificate::$hashed));
      print_r($str);
      dd($str);

    }
  }
}