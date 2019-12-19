<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Models\MrCertificate;
use App\Http\Models\MrCertificateMonitoring;
use App\Http\Models\MrUser;
use App\Http\Models\MrUserInOffice;
use Illuminate\Http\RedirectResponse;

class MrOfficeController extends Controller
{
  /**
   * Настроки ВО, отчёты и прочие инструменты
   *
   */
  public function settingsPage()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;
    $out['page_title'] = 'Персональные настройки';
    $out['office'] = $user->getDefaultOffice();
    return View('Office.office_settings_page')->with($out);
  }

  /**
   * Главная страница ВО
   *
   */
  public function officePage()
  {
    $out = array();
    $user = MrUser::me();
    $out['user'] = $user;
    $out['page_title'] = 'Работа с сертификатами';
    $user_in_office = $user->GetUserInOffice();
    $out['monitoring_list'] = $id = MrCertificateMonitoring::GetUserCertificateMonitoringList($user_in_office);
    $out['cache_search'] = MrCertificate::GetCacheSearch($user);
    return View('Office.office_page')->with($out);
  }

  public function financePage()
  {
    $out = array();
    $out['page_title'] = 'Финансы';
    $user = MrUser::me();
    $out['office'] = $user->getDefaultOffice();

    return View('Office.office_finance_page')->with($out);
  }

  /**
   * Смена статуса пользователя относительно офиса: админ или пользователь
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function userOfficeIsAdmin(int $id)
  {
    $tariff_office = MrUserInOffice::loadBy($id);
    if($tariff_office->getIsAdmin())
    {
      $tariff_office->setIsAdmin(false);
    }
    else
    {
      $tariff_office->setIsAdmin(true);
    }
    $tariff_office->save_mr();

    return back();
  }
}