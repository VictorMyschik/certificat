<?php

namespace App\Http\Controllers;


use App\Models\MrUser;

class HomeController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {

    $out = array();

    return View('home')->with($out);
  }
}
