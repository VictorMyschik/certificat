<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;

class MrTestController extends Controller
{
  public function index()
  {
    $file = public_path() . '/files/cert.xml';
    $xml = simplexml_load_file($file);
    foreach ($xml->entry as $item)
    {
      $ns = $item->content->children('http://schemas.microsoft.com/ado/2007/08/dataservices/metadata');
      $nsd = $ns->properties->children("http://schemas.microsoft.com/ado/2007/08/dataservices");
      MrXmlImportBase::importCertificate($nsd);
    }
  }
}