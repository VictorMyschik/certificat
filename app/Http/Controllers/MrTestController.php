<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MtExcelHelperBase;
use App\Http\Models\MrOffice;

class MrTestController extends MtExcelHelperBase
{
  public function index()
  {
    $out = array();

    $user = MrOffice::loadBy(1);

    $user->setName(12567563);

    $user->save_mr();


    return View('test')->with($out);
  }
}