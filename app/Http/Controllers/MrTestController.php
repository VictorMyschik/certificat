<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrApplicant;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCertificateMonitoring;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrDocument;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use App\Models\Certificate\MrProduct;
use App\Models\Certificate\MrProductInfo;
use App\Models\Lego\MrCertificateDocument;
use App\Models\Lego\MrCommunicateInTable;
use Illuminate\Http\Request;

class MrTestController extends Controller
{
  public function index(Request $request)
  {
    $out = array();
    $files = scandir(public_path() . '/files');

    // удаление шлака
    foreach ($files as $key => $file_q)
    {
      if (strlen($file_q) < 3)
      {
        unset($files[$key]);
      }
    }


    if ($name = $request->get('file_name'))
    {
      // Очистка перед импортом
      if ($request->get('clear'))
      {
        $this->ClearCertificate();
      }

      if (array_search($name, $files))
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
    ini_set('max_execution_time', 500000000000);
    $files = scandir('files');

    // удаление шлака
    foreach ($files as $key => $file_q)
    {
      if (strlen($file_q) < 3)
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

  public function ClearCertificate()
  {
    MrCertificate::AllDelete();
    MrCertificateDocument::AllDelete();
    MrCommunicate::AllDelete();
    MrCommunicateInTable::AllDelete();
    MrConformityAuthority::AllDelete();
    MrDocument::AllDelete();
    MrManufacturer::AllDelete();
    MrAddress::AllDelete();
    MrFio::AllDelete();
    MrApplicant::AllDelete();
    MrProductInfo::AllDelete();
    MrProduct::AllDelete();
    MrCertificateMonitoring::AllDelete();
  }
}