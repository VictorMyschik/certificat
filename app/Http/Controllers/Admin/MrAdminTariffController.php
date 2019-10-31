<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrTariff;

class MrAdminTariffController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Тарифные планы';

    $out['list'] = MrTariff::GetAll();

    return View('Admin.mir_admin_tariffs')->with($out);
  }
}