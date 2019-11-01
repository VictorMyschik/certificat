<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class MrAdminOfficeController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Виртуальные офисы';

    $out['list'] = array();

    return View('Admin.mir_admin_office')->with($out);
  }
}