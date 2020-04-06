<?php


namespace App\Http\Controllers;


use App\Http\Controllers\TableControllers\MrCertificateTableController;
use App\Models\MrCertificate;

class MrCertificateController extends Controller
{
  public function List()
  {
    return MrCertificateTableController::buildTable();
  }

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