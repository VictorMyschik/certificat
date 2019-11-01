<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Helpers\MtDateTime;

class MrTestController extends Controller
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
    $out = array();
    $qwe = MtDateTime::fromValue('2019-05-18');

    dd($qwe);

    return View('test')->with($out);
  }

}