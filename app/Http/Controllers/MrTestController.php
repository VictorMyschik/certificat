<?php

namespace App\Http\Controllers;




use App\Http\Models\MrCountry;

class MrTestController extends Controller
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
    $out = array();



    return View('test')->with($out);
  }

}