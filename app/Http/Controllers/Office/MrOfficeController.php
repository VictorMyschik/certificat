<?php

namespace App\Http\Controllers\Office;

use App\Helpers\MrDateTime;
use App\Helpers\MrEmailHelper;
use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\MrCertificateMonitoringShortTableController;
use App\Http\Controllers\TableControllers\MrCertificateMonitoringTableController;
use App\Http\Controllers\TableControllers\MrNewUserInOfficeTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Http\Controllers\TableControllers\MrUserInOfficeTableController;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCertificateMonitoring;
use App\Models\MrEmailLog;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\Office\MrUserInOffice;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MrOfficeController extends Controller
{
  public function ChangeOffice(int $office_id)
  {
    parent::CheckAndChangeOffice($office_id);
    return redirect()->route('office_page');
  }

  /**
   * Настройки ВО, отчёты и прочие инструменты
   *
   * @return Factory|View
   */
  public function settingsPage()
  {
    $user = MrUser::me();

    $out = array();
    $office = $user->getDefaultOffice();

    $out['me'] = $user;
    $out['page_title'] = 'Персональные настройки';
    $out['office'] = $office;
    $out['uio_table'] = MrTableController::buildTable(MrUserInOfficeTableController::class, ['office_id' => $office->id()]);
    $out['new_table'] = MrTableController::buildTable(MrNewUserInOfficeTableController::class, ['office_id' => $office->id()]);

    return View('Office.office_settings_page')->with($out);
  }


  /**
   * Главная страница ВО
   *
   * @return Factory|View
   */
  public function officePage()
  {
    $user = MrUser::me();
    if(!$user->getDefaultOffice())
    {
      return redirect('/');
    }

    $out = array();
    $out['user_history'] = $user->GetSearchHistory();

    return View('Office.office_page')->with($out);
  }

  /**
   * Смена полномочий пользователя в ВО
   *
   * @param int $id User in office
   * @return RedirectResponse
   */
  public function ChangeUserRoleInOffice(int $id)
  {
    $uio = MrUserInOffice::loadByOrDie($id);
    $office = MrUser::me()->getDefaultOffice();

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
   * @param int $new_user_id
   * @return RedirectResponse
   */
  public function ResendEmailForNewUser(int $new_user_id)
  {
    $user = MrUser::me();
    $new_user = MrNewUsers::loadByOrDie($new_user_id);
    $office = $user->getDefaultOffice();

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
          if($diff < 1) // период 3 минуты
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

    if($uio->getOffice()->id() == $user->getDefaultOffice()->id())
    {
      $user->setDefaultOfficeID(null);
    }

    $uio->mr_delete();
    $uio->flush();
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
   * @param int $id
   * @return RedirectResponse
   */
  public function NewUserOfficeIsAdmin(int $id)
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


  /**
   * Поиск сертификатов
   *
   * @param Request $request
   * @return array|null
   */
  public function SearchApi(Request $request)
  {
    if($search_text = $request->get('text'))
    {
      return MrCertificate::Search($search_text);
    }

    return null;
  }

  /**
   * Сохранение истории поиска. Вернёт обновлённую историю.
   *
   * @param string $search_query
   * @return array
   */
  public function SetUserSearchHistory(string $search_query): array
  {
    $user = MrUser::me();
    $user->SetSearchStory($search_query);

    return $user->GetSearchHistory();
  }

  public function GetCertificate(int $id)
  {
    return MrCertificate::loadBy($id)->GetJsonData();
  }

  /**
   * Добавить сертификат для отслеживания
   *
   * @param int $certificate_id
   * @return array
   */
  public function AddCertificateToMonitoring(int $certificate_id): array
  {
    $user = MrUser::me();

    if(!$user->getDefaultOffice()->canEdit())
    {
      mr_access_violation();
    }

    $certificate = MrCertificate::loadByOrDie($certificate_id);

    $monitoring = MrCertificateMonitoring::loadBy($certificate->id(), 'CertificateID') ?: new MrCertificateMonitoring();
    $monitoring->setCertificateID($certificate->id());
    $monitoring->setOfficeID($user->getDefaultOffice()->id());
    $monitoring->save_mr();

    return ['certificate' => $certificate->getNumber()];
  }

  /**
   * Сокращённый список недавно добавлнных сертификатов для отслеживания
   * Упрощённый список
   *
   * @return array
   */
  public function CertificateMonitoringShortList()
  {
    $office = MrUser::me()->getDefaultOffice();
    return MrTableController::buildTable(MrCertificateMonitoringShortTableController::class, ['office_id' => $office->id()]);
  }

  public function CertificateMonitoringList()
  {
    $office = MrUser::me()->getDefaultOffice();
    return MrTableController::buildTable(MrCertificateMonitoringTableController::class, ['office_id' => $office->id()]);
  }

  /**
   * Страница отслеживания сертификатов
   */
  public function OfficeWatchPage()
  {
    $out = array();
    $out['page_title'] = __('mr-t.Мои сертификаты');

    return View('Office.watch')->with($out);
  }
}