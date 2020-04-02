<?php


namespace App\Forms\User;


use App\Forms\FormBase\MrFormBase;
use App\Helpers\MrBaseHelper;
use App\Helpers\MrTelegramHelper;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\MrUserInOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    $code = MrBaseHelper::RandomNumberString(MrTelegramHelper::LENGTH_CODE);

    Cache::remember('telegram_code_' . $user->id(), '3600', function () use ($code) {
      return $code;
    });

    $code_out = '<span class="mr-color-green-dark">' . $code . '</span>';

    $form[] = MrTelegramHelper::getBotQRCode();

    $boot = '<a href="tg://resolve?domain=" class="text-center">' . MrBaseHelper::TELEGRAM_BOT . '</a>';
    $form[] = "<h6>Отправьте этот код: {$code_out} нашему роботу {$boot} и впишите ответ ниже</h6>";

    $form['Code'] = array(
      '#type' => 'textfield',
      '#title' => 'Код ответа',
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
