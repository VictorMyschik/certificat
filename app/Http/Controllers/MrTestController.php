<?php

namespace App\Http\Controllers;

use App\Models\Certificate\MrConformityAuthority;
use App\Models\MrTemp;
use App\Models\References\MrCountry;

class MrTestController extends Controller
{
  public function index()
  {

    /** @var MrTemp $row */
    foreach (MrTemp::GetAll() as $row)
    {

      $data = json_decode($row->getRawData(), true);
      dd($data);
      $item = $data['conformityAuthorityV2Details'];


      $authority = new MrConformityAuthority();

      $authority->setConformityAuthorityId($item['conformityAuthorityId']);
      $country = MrCountry::loadBy($data['unifiedCountryCode']['value'],'ISO3166alpha2');
      $authority->setCountryID($country->id());
      $authority->setDocumentNumber($item['docId']);
      $authority->setDocumentDate($item['docCreationDate']);





      $authority->setOfficerDetailsID($item['']);

      $authority->save_mr();
    }
  }
}