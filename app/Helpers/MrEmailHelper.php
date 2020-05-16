<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\MrEmailLog;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use Illuminate\Support\Facades\Artisan;

class MrEmailHelper extends Controller
{
  public static function SendNewUser($id): bool
  {
    $system = MrBaseHelper::MR_SITE_NAME;
    $subject = __('mr-t.Новый пользователь в системе') . ' ' . MrBaseHelper::MR_SITE_NAME;
    $new_user = MrNewUsers::loadBy($id);
    $link = MrNewUsers::GetLinkForNewUser($new_user->getCode());

    $email_to = $new_user->getEmail();

    $regex = '/\S+@\S+\.\S+/';

    if(!preg_match($regex, $email_to))
    {
      return false;
    }

    $user = MrUser::me();

    $message_text = <<< HTML
        <body>
        <h3>Здравствуйте!</h3>
<p>Для аккаунта с адресом {$email_to} был предоставлен доступ к виртуальному офису {$new_user->getOffice()->getName()} в Системе {$system}.</p>
<p>Для входа в Систему {$system} вы можете воспользоваться следующей ссылкой: {$link}
</p>
<p>Если Вы получили данное письмо по ошибке, проигнорируйте его.</p>
        </body>
HTML;

    $data = array(
      'user'         => $user,
      'subject'      => $subject,
      'message_text' => $message_text,
      'email_to'     => $email_to,
    );


    return true;
  }

  /**
   * Отправка почты для нового пользователя добавленного из уже зарегистрированных
   *
   * @param int $office_id Office
   * @param string $email
   */
  public static function SendNewUserRole(int $office_id, string $email)
  {
    $system = MrBaseHelper::MR_SITE_NAME;
    $site_url = MrBaseHelper::MR_SITE_URL;
    $link_login = $site_url . '/login';
    $user = MrUser::me();
    $subject = __('mr-t.Предоставление доступа к системе') . ' ' . MrBaseHelper::MR_SITE_NAME;

    $data = array(
      'user'       => $user,
      'title'      => $subject,
      'email_to'   => $email,
      'office'     => MrOffice::loadBy($office_id),
      'template'   => 'email_has_user',
      'link_login' => $link_login,
      'system'     => $system,
    );

    dispatch((new SendEmailJob($data))->delay(now()->addSeconds(3)));
    Artisan::call('queue:work --once');

    // В лог
    $log = new MrEmailLog();
    $log->setAuthorUserID($user->id());
    $log->setEmailTo($email);
    $log->setTitle($subject);
    $log->setText('template "email_has_user"');
    $log->save_mr();
  }

  /**
   * Переотправить письмо существующему пользователю
   *
   * @param MrNewUsers $user
   */
  public static function ReSendNewUser(MrNewUsers $user)
  {
    if(MrUser::LoadUserByEmail($user->getEmail()))
    {
      self::SendNewUserRole($user->getOffice()->id(), $user->getEmail());
    }
  }
}