<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\MrCertificate;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrAdminCertificateController extends Controller
{
  public function View()
  {
    $out = array();
    $out['page_title'] = 'Сертификаты';

    return View('Admin.Certificate.mir_admin_certificate')->with($out);
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

    MrMessageHelper::SetMessage(true, 'Успешно удален');

    return back();
  }

  /**
   * Страница седений об адресах, таких как Email, Телефон и прочее
   */
  public function ViewCommunicate()
  {
    $out = array();
    $out['page_title'] = 'Связь';

    return View('Admin.Certificate.mir_admin_certificate_communicate')->with($out);
  }

  /**
   * Api получение таблицы телефонов и Email-ов
   */
  public function CommunicateList()
  {

  }
}