<?php

namespace App\Http\Controllers\Office;

use App\Helpers\MrDateTime;
use App\Helpers\MrEmailHelper;
use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\MrNewUserInOfficeTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Http\Controllers\TableControllers\MrUserInOfficeTableController;
use App\Models\MrEmailLog;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use App\Models\Office\MrUserInOffice;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MrOfficeController extends Controller
{
  /**
   * Настройки ВО, отчёты и прочие инструменты
   *
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
    $out['uio_table'] = MrTableController::buildTable(MrUserInOfficeTableController::class, ['office_id' => $office->id()]);
    $out['new_table'] = MrTableController::buildTable(MrNewUserInOfficeTableController::class, ['office_id' => $office->id()]);

    return View('Office.office_settings_page')->with($out);
  }

  /**
   * @return RedirectResponse|Redirector
   */
  public function officePageDefault()
  {
    $office = MrUser::me()->getDefaultOffice();

    if(!$office)
    {
      return redirect('/');
    }

    return redirect()->route('office_page', ['office_id' => $office->id()]);
  }

  /**
   * Главная страница ВО
   *
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
   * Смена полномочий пользователя в ВО
   *
   * @param int $office_id
   * @param int $id User in office
   * @return RedirectResponse
   */
  public function userOfficeIsAdmin(int $office_id, int $id)
  {
    $uio = MrUserInOffice::loadByOrDie($id);
    $office = MrOffice::loadByOrDie($office_id);

    if(!$office->canEdit() || $uio->getOffice()->id() != $office->id())
    {
      mr_access_violation();
    }

    if($uio->getIsAdmin())
    {
      $i = 0;
      foreach ($office->GetUsers() as $uio_item)
      {
        if($uio_item->getIsAdmin())
        {
          $i++;
        }
      }

      if($i == 1)
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Нельзя оставить виртуальный офис без администратора');
        return back();
      }

      $uio->setIsAdmin(false);
    }
    else
    {
      $uio->setIsAdmin(true);
    }

    $uio->save_mr();
    $uio->getOffice()->flush();
    $uio->flush();

    return back();
  }

  /**
   * Переотправка письма для приглашённого пользователя
   *
   * @param int $office_id
   * @param int $new_user_id
   * @return RedirectResponse
   */
  public function ResendEmailForNewUser(int $office_id, int $new_user_id)
  {
    $new_user = MrNewUsers::loadByOrDie($new_user_id);
    $office = MrOffice::loadByOrDie($office_id);

    if(!$office->canEdit())
    {
      mr_access_violation();
    }

    // Новый пользователь должен быть привязан к офису
    foreach ($office->GetNewUsers() as $new_exist_user)
    {
      if($new_exist_user->id() == $new_user->id())
      {

        // Предовращение серии писем
        if($email_log = MrEmailLog::loadBy($new_user->getEmail(), 'EmailTo'))
        {
          $diff = $email_log->getWriteDate()->diff(MrDateTime::now())->i;
          if($diff < 3) // период 3 минуты
          {
            MrMessageHelper::SetMessage(MrMessageHelper::KIND_WARNING, 'Повоторите попытку через несколько минут');
            return back();
          }
        }

        MrEmailHelper::SendNewUser($new_user);
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, __('mr-t.Сообщение было переотправлено'));

        return back();
      }
    }

    MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, __('mr-t.Пользователь не найден'));
    return back();
  }

  /**
   * Удаление пользователя из офиса
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function UserInOfficeDelete(int $id)
  {
    $uio = MrUserInOffice::loadBy($id);

    if(!$uio->catEdit())
    {
      mr_access_violation();
    }

    // Очистка из getDefaultOffice
    $user = $uio->getUser();

    if($uio->getOffice()->id() == $user->getDefaultOffice())
    {
      $user->setDefaultOfficeID(null);

    }

    $uio->mr_delete();
    $user->save_mr();
    $user->flush();

    if(!MrUser::me()->getDefaultOffice())
    {
      return redirect('/');
    }

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
   * @param int $office_id
   * @param int $id
   * @return RedirectResponse
   */
  public function NewUserDelete(int $office_id, int $id)
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