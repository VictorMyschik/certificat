<?php


namespace App\Http\Controllers\Forms\User;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Controllers\Helpers\MrEmailHelper;
use App\Http\Controllers\Helpers\MrTelegramHelper;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrUser;
use App\Http\Models\MrUserInOffice;
use Illuminate\Http\Request;

class MrUserTelegramEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $user = MrUser::loadBy($id);
    if(!$user->canEdit())
    {
      return mr_access_violation();
    }

    $form['#title'] = 'Оповещать в Telegram';

    $form[] = MrTelegramHelper::getBotQRCode();

    $form['Telegram_Login'] = array(
      '#type' => 'textfield',
      '#title' => 'Telegram Login',
      '#value' => '',
    );

    $form['Code'] = array(
      '#type' => 'textfield',
      '#title' => 'Код',
      '#value' => '',
    );

    $form[] = '<p><i class="fa fa-info-circle mr-color-green"></i> Укажите код, который Вы получили</p>';
    $form[] = '<script src="/public/js/mr_send_telegram_code.js"></script>';

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    $user = MrUser::loadBy($v['id']);
    if(!$user->canEdit())
    {
      return mr_access_violation();
    }


    if(!$v['Telegram_Login'])
    {
      $out['Telegram_Login'] = 'Telegram Login ' . __('mr-t.обязательно');
    }
    else
    {
      $out['Email'] = 'Email обязателен';
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

      $new_user_id = $new_user->save_mr();

      MrEmailHelper::SendNewUser($new_user_id);
    }

    return;
  }
}