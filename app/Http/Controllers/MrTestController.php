<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MrTestController extends Controller
{
  public function index(Request $request)
  {

    $r = DB::table('failed_jobs')->get();

    foreach ($r as $item)
    {
      dd($item);
    }

    dd(1);

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

    //$this->qwe();


    $out = array();
    $files = scandir('files');

    // удаление шлака
    foreach ($files as $key => $file_q)
    {
      if(strlen($file_q) < 3)
      {
        unset($files[$key]);
      }
    }


    if($name = $request->get('file_name'))
    {
      if(array_search($name, $files))
      {
        ini_set('max_execution_time', 50000);
        $file = public_path() . '/files/' . $name;
        $this->asd($file);
      }
    }

    $out['file_name'] = $files;
    return View('test')->with($out);
  }

  /**
   * считывание папки и парсинг всех файлов
   */
  public function qwe()
  {
    ini_set('max_execution_time', 50000);
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
      $this->asd($file);
    }
  }

  public function asd(string $path)
  {

    $xml = simplexml_load_file($path);
    MrXmlImportBase::parse($xml);
  }
}