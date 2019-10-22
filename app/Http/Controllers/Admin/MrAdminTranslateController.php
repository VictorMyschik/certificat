<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class MrAdminTranslateController extends Controller
{
  public function LanguageList()
  {
    $out = array();


    return View('Admin.mir_admin_translate')->with($out);
  }
}