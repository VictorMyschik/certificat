<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class MrAdminTariffController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Тарифные планы';

    $out['list'] = array();

    return View('Admin.mir_admin_tariffs')->with($out);
  }
}