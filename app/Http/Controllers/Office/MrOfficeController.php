<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Controllers\TableControllers\MrUserInOfficeTableController;
use App\Http\Models\MrCertificate;
use App\Http\Models\MrCertificateMonitoring;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrOffice;
use App\Http\Models\MrUser;
use App\Http\Models\MrUserInOffice;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MrOfficeController extends Controller
{
  /**
   * Настроки ВО, отчёты и прочие инструменты
   * @param int $id
   * @return Factory|View
   */
  public function settingsPage(int $id)
  {
    $user = MrUser::me();
    $office = MrOffice::loadBy($id);
    if(!$office || !$office->canView())
    {
      abort(503, __('mr-t.Нет прав доступа'));
    }

    $out = array();

    $out['me'] = $user;
    $out['page_title'] = 'Персональные настройки';
    $out['office'] = $office;

    $out['user_in_office'] = MrUserInOfficeTableController::buildTable($office->GetUsers(), $office->GetNewUsers());
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
    $me = MrUser::me();
    $uio = MrUserInOffice::loadBy($id);

    if(!$me->GetUserInOffice()->getIsAdmin())
    {
      MrMessageHelper::SetMessage(false, 'Только администры могут менять статус.');
      return back();
    }

    if(!$uio || !$me->getDefaultOffice()->IsUserInOffice($uio->getUser()))
    {
      MrMessageHelper::SetMessage(false, 'Пользователь не найден.');
      return back();
    }

    if($uio->getIsAdmin())
    {
      $uio->setIsAdmin(false);
    }
    else
    {
      $uio->setIsAdmin(true);
    }
    $uio->save_mr();

    return back();
  }

  /**
   * Поменять привилегии у приглашённого пользователя
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function NewUserOfficeIsAdmin(int $id)
  {
    $new_user = MrNewUsers::loadBy($id);

    if(!$new_user->canEdit())
    {
      abort('503', __('mr-t.Нарушение доступа'));
    }

    $new_user->setIsAdmin($new_user->getIsAdmin() ? false : true);
    $new_user->save_mr();

    return back();
  }

  /**
   * Удалить приглашённого пользователя
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function NewUserDelete(int $id)
  {
    $new_user = MrNewUsers::loadBy($id);
    if(!$new_user->canDelete())
    {
      abort('503', __('mr-t.Нарушение доступа'));
    }

    $new_user->mr_delete();

    return back();
  }
}