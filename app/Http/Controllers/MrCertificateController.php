<?php


namespace App\Http\Controllers;


use App\Http\Models\MrCertificate;

class MrCertificateController extends Controller
{

  public function View(string $number)
  {
    $certificate = MrCertificate::loadBy($number);

    $out = array();
    if($certificate)
    {
      $out['certificate'] = $certificate;
      return View('certificate_view')->with($out);
    }
    else
    {
      return redirect()->action('MrError404Controller@indexView','404');
    }
  }
}