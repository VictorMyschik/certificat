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

  /**
   * тестовая страница для поиска сертификата
   */
  public function SearchPage()
  {
    $out = array();


    return View('test_search')->with($out);
  }

  public function SearchApi(Request $request)
  {
    $certificate = MrCertificate::Search($request->get('text'));
    if($certificate)
    {
      return ['data' => $certificate];
    }
    return null;
  }

  public function GetCertificate(int $id)
  {
    return MrCertificate::loadBy($id)->GetJsonData();
  }
}
