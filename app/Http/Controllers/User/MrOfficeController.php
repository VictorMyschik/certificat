<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\MrUser;

class MrOfficeController extends Controller
{
  public function View()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;

    return View('Office.home')->with($out);
  }
}