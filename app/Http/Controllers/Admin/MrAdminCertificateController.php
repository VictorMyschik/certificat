<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Models\MrCertificate;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrAdminCertificateController extends Controller
{
  public function View()
  {
    $out = array();
    $out['countries'] = array();
    $out['list'] = MrCertificate::GetAll();


    return View('Admin.mir_admin_certificate')->with($out);
  }

  /**
   * Удаление сертификата
   *
   * @param int $id
   * @return Factory|View
   */
  public function certificateDelete(int $id)
  {
    $certificate = MrCertificate::loadBy($id);
    $certificate->mr_delete();

    MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Успешно удален');

    return back();
  }

  /**
   * Удаление сведения о сертификате
   *
   * @param int $certificate_id
   * @param int $id
   * @return Factory|View
   */
  public function certificateDetailsDelete(int $certificate_id, int $id)
  {
    $certificate = MrCertificate::loadBy($certificate_id);
    foreach ($certificate->GetDetails() as $details)
    {
      if($details->id() == $id)
      {
        $details->mr_delete();
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Успешно удален.');

        return back();
      }
    }

    MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Инфо о сертификате не найдено.');
    return back();
  }

  /**
   * Сраница сведений о сертификате
   *
   * @param int $id
   * @return Factory|View
   */
  public function CertificateDetails(int $id)
  {
    $certificate = MrCertificate::loadBy($id);
    $details = $certificate->GetDetails();

    $out = array();

    $out['list'] = $details;
    $out['certificate'] = $certificate;

    return View('Admin.mir_admin_certificate_details')->with($out);
  }
}