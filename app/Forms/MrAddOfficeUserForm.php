<?php

namespace App\Forms;

use App\Forms\FormBase\MrFormBase;
use App\Helpers\MrEmailHelper;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use App\Models\Office\MrUserInOffice;
use Illuminate\Http\Request;

/**
 *Добавление нового пользователя в ВО
 */
class MrAddOfficeUserForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['#title'] = 'Добавить пользователя в ВО';

    $form['Email'] = array(
      '#type'  => 'email',
      '#title' => 'Email',
      '#value' => '',
    );

    $form['IsAdmin'] = array(
      '#type'  => 'checkbox',
      '#title' => 'Администратор',
      '#value' => 1,
    );

    $form[] = '<p><i class="fa fa-info-circle mr-color-green"></i> На электронный адрес придёт ссылка на активацию акаунта</p>';

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    $office = MrOffice::loadBy($v['id']);
    if(!$office->canEdit())
    {
      mr_access_violation();
    }

    if($v['Email'])
    {
      $regex = '/\S+@\S+\.\S+/';
      if(!preg_match($regex, $v['Email']))
      {
        $out['Email'] = 'Невернай формат Email';
      }
    }
    else
    {
      $out['Email'] = 'Email обязателен';
    }

    if($v['Email'] && !isset($out['Email']))
    {
      foreach ($office->GetUsers() as $uio)
      {
        if($uio->getUser()->getEmail() == $v['Email'])
        {
          $out['Email'] = 'Пользователь уже добавлен в ВО';
        }
      }

      foreach ($office->GetNewUsers() as $nuio)
      {
        if($nuio->getEmail() == $v['Email'])
        {
          $out['Email'] = 'Пользователь уже приглашён в ВО';
        }
      }
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $is_admin = isset($v['IsAdmin']) ? $v['IsAdmin'] : false;

    // Email есть в системе - просто даём доступ и отправляем уведомление
    if($has_user = MrUser::LoadUserByEmail($v['Email']))
    {
      $uio = new MrUserInOffice();
      $uio->setUserID($has_user->id());
      $uio->setOfficeID($id);
      $uio->setIsAdmin((bool)$is_admin);
      $uio->save_mr();

      MrEmailHelper::SendNewUserRole($id, $v['Email']);
    }
    // Иначе отправляем запрос на регистрацию нового пользователя
    else
    {
      $code = md5(time());
      $user = MrUser::me();

      $new_user = MrNewUsers::loadBy((string)$v['Email'], 'Email') ?: new MrNewUsers();
      $new_user->setEmail((string)$v['Email']);
      $new_user->setUserID($user->id());
      $new_user->setOfficeID($id);
      $new_user->setIsAdmin((bool)$is_admin);
      $new_user->setCode($code);

      $new_user->save_mr();
      $new_user->reload();

      MrEmailHelper::SendNewUser($new_user);
    }

    return;
  }
}