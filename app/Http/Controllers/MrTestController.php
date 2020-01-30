<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MtExcelHelperBase;

class MrTestController extends MtExcelHelperBase
{
  public function index()
  {
    $out = array();


    return View('test')->with($out);
  }
}