<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\MrUserInOfficeTableController;
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
   * @param int $office_id
   * @return Factory|View
   */
  public function settingsPage(int $office_id)
  {
    $office = parent::has_permission($office_id);
    $user = MrUser::me();

    $out = array();

    $out['me'] = $user;
    $out['page_title'] = 'Персональные настройки';
    $out['office'] = $office;

    $out['user_in_office'] = MrUserInOfficeTableController::buildTable($office->GetUsers(), $office->GetNewUsers(), $office);
    return View('Office.office_settings_page')->with($out);
  }

  /**
   * Главная страница ВО
   * @param int $office_id
   * @return Factory|View
   */
  public function officePage(int $office_id)
  {
    $office = parent::has_permission($office_id);

    $out = array();
    return View('Office.office_page')->with($out);
  }

  /**
   * Смена статуса пользователя в ВО: админ или пользователь
   *
   * @param int $office_id
   * @param int $id
   * @return RedirectResponse
   */
  public function userOfficeIsAdmin(int $office_id, int $id)
  {
    $uio = MrUserInOffice::loadBy($id);
    $office = MrOffice::loadBy($office_id);

    if(!$office || !$office->canEdit() || !$uio || $uio->getOffice()->id() != $office->id())
    {
      mr_access_violation();
    }

    if($uio->getIsAdmin())
    {
      $uio->setIsAdmin(0);
    }
    else
    {
      $uio->setIsAdmin(1);
    }

    $uio->save_mr();

    return back();
  }

  public function UserInOfficeDelete(int $id)
  {
    $uio = MrUserInOffice::loadBy($id);
    if(!$uio->catEdit())
    {
      mr_access_violation();
    }

    $uio->mr_delete();

    return back();
  }

  /**
   * Поменять привилегии у приглашённого пользователя
   *
   * @param int $office_id
   * @param int $id
   * @return RedirectResponse
   */
  public function NewUserOfficeIsAdmin(int $office_id, int $id)
  {
    $new_user = MrNewUsers::loadBy($id);

    if(!$new_user->canEdit())
    {
      mr_access_violation();
    }

    $new_user->setIsAdmin($new_user->getIsAdmin() ? false : true);
    $new_user->save_mr();

    return back();
  }

  /**
   * Удалить приглашённого пользователя
   *
   * @param int $id
   * @param int $office_id
   * @return RedirectResponse
   */
  public function NewUserDelete(int $id)
  {
    $new_user = MrNewUsers::loadBy($id);
    if(!$new_user->canDelete())
    {
      mr_access_violation();
    }

    $new_user->mr_delete();

    return back();
  }
}