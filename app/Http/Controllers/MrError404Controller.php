<?php

namespace App\Http\Controllers;


class MrError404Controller extends Controller
{
  public function indexView()
  {
    return View('404');
  }
}