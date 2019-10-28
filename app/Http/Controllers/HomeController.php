<?php

namespace App\Http\Controllers;


use App\Http\Models\MrCertificate;
use App\Models\MrVisitCard;
use Illuminate\Http\Request;

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

  /**
   * Живой поиск
   *
   * @param Request $request
   * @return array
   */
  public function search(Request $request): array
  {
    $out = array();
    $list = MrCertificate::Search($request->get('search', null));

    foreach ($list as $item)
    {
      $out[$item->getNumber()] = $item->GetFullName();
    }


    return $out;
  }
}
