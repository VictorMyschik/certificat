<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Models\MrCertificate;
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
    $user_in_office = $user->GetUserInOffice();
    $out['monitoring_list'] = $id = MrCertificateMonitoring::GetUserCertificateMonitoringList($user_in_office);
    $out['cache_search'] = MrCertificate::GetCacheSearch($user);
    return View('Office.certificate_monitoring')->with($out);
  }
}