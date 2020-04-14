<?php

namespace App\Http\Controllers;

use App\Classes\Xml\MrXmlImportBase;

class MrTestController extends Controller
{
  public function index()
  {
    $file = public_path() . '/files/example.xml';
    $xml = simplexml_load_string(file_get_contents($file), 'SimpleXMLElement', LIBXML_NOENT | LIBXML_NOCDATA | LIBXML_COMPACT);
    //dd($xml);
    foreach ($xml as $item)
    {
      $conformityAuthority = $item->conformityAuthorityV2Details;
      MrXmlImportBase::importConformityAuthority($conformityAuthority);
    }
  }
}