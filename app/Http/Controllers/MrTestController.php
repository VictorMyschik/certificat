<?php

namespace App\Http\Controllers;

use App\Classes\Json\MrJsonImportBase;
use App\Models\MrTemp;
use App\Models\References\MrCountry;

class MrTestController extends Controller
{
  public function index()
  {
    $temp = MrTemp::GetAll();

    foreach ($temp as $item)
    {
      $data = json_decode($item->getRawData(), true);
      $country = MrCountry::loadBy($data['unifiedCountryCode']['value'],'ISO3166alpha2');
      MrJsonImportBase::importConformityAuthority($data['conformityAuthorityV2Details'], $country);


    }
  }
}