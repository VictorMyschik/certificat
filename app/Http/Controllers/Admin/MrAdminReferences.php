<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\MrCountry;

class MrAdminReferences extends Controller
{
  public function getCountryReference()
  {
    $out = array();

    $out['list'] = MrCountry::GetAll();

    return View('Admin.mir_admin_reference_country')->with($out);
  }

}