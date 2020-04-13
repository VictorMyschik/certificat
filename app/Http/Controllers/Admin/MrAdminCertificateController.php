<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateCommunicateTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateManufacturerTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrManufacturer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
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
    $out['route_name'] = route('list_communicate_table');

    return View('Admin.Certificate.mir_admin_certificate_communicate')->with($out);
  }

  /**
   * Api получение таблицы телефонов и Email-ов
   */
  public function CommunicateList()
  {
    return MrTableController::buildTable(MrCertificateCommunicateTableController::class);
  }

  /**
   * Удаление телефона, email
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function CommunicateDelete(int $id)
  {
    $communicate = MrCommunicate::loadBy($id);

    if($communicate)
    {
      $communicate->mr_delete();
    }

    return back();
  }

  /**
   * Страница производителей
   *
   * @return Factory|View
   */
  public function ViewManufacturer()
  {
    $out = array();
    $out['page_title'] = 'Производители';
    $out['route_name'] = route('list_manufacturer_table');

    return View('Admin.Certificate.mir_admin_certificate_manufacturer')->with($out);
  }

  /**
   * Таблица производителей
   *
   * @return array
   */
  public function ManufacturerList()
  {
    return MrTableController::buildTable(MrCertificateManufacturerTableController::class);
  }

  /**
   * Удаление производителя
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function ManufacturerDelete(int $id)
  {
    $manufacturer = MrManufacturer::loadBy($id);

    if(!$manufacturer->canEdit())
    {
      mr_access_violation();
    }

    $manufacturer->mr_delete();

    return back();
  }
}