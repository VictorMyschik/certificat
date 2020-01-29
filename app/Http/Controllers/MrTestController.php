<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MtExcelHelperBase;
use App\Http\Models\MrCurrency;

class MrTestController extends MtExcelHelperBase
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {


    $out = array();
    $data = MrCurrency::paginate(10);

    $out['post'] = $data;

    return View('test')->with($out);
  }
}