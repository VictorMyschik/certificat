<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return Renderable
   */
  public function index()
  {

    $out = array();

    return View('home')->with($out);
  }
}
