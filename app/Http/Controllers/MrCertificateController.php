<?php


namespace App\Http\Controllers;


use App\Http\Models\MrCertificate;

class MrCertificateController extends Controller
{
  public function View(string $number)
  {
    $certificate = MrCertificate::loadBy($number, 'Number');

    $out = array();
    if($certificate)
    {
      $out['certificate'] = $certificate;
      $date = $certificate->getWriteDate();
      foreach ($certificate->GetDetails() as $details)
      {
        if($details->getWriteDate()->isAfter($date))
        {
          $date = $details->getWriteDate();
        }
      }

      $out['actual_date'] = $date;

      return View('certificate_view')->with($out);
    }
    else
    {
      return redirect()->action('MrError404Controller@indexView', '404');
    }
  }
}