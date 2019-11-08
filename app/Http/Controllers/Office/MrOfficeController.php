<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Models\MrCertificateMonitoring;
use App\Http\Models\MrUser;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrOfficeController extends Controller
{
  public function View()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;
    $out['office'] = $user->getOffice();

    return View('Office.home')->with($out);
  }

  /**
   * Страница редактирования информации о ВО
   *
   * @return Factory|View
   */
  public function personalPage()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;
    $out['office'] = $user->getOffice();

    return View('Office.personal')->with($out);
  }

  /**
   * Настроки ВО, отчёты и прочие инструменты
   *
   * @return Factory|View
   */
  public function settingsPage()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;

    return View('Office.settings')->with($out);
  }

  public function monitoringPage()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;

    $out['monitoring_list'] = $id = MrCertificateMonitoring::GetByUser($user);
dd($id);
    return View('Office.settings')->with($out);
  }
}