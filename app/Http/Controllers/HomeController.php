<?php

namespace App\Http\Controllers;


use App\Models\Certificate\MrCertificate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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
