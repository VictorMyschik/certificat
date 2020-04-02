<?php


namespace App\Helpers;


use App\Http\Controllers\Controller;
use App\Jobs\SendReminderEmail;
use App\Models\MrNewUsers;
use App\Models\MrOffice;
use App\Models\MrUser;

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
      'user' => $user,
      'subject' => $subject,
      'message_text' => $message_text,
      'email_to' => $email_to,
    );

    SendReminderEmail::dispatch($data);

    return true;
  }

  /**
   * Отправка почты для нового пользователя добавленного из уже зарегистрированных
   *
   * @param int $id Office
   * @param string $email
   */
  public static function SendNewUserRole(int $id, string $email)
  {
    $system = MrBaseHelper::MR_SITE_NAME;
    $site_url = MrBaseHelper::MR_SITE_URL;
    $link_login = "<a href='{$site_url}/login'>Вход</a>";
    $user = MrUser::me();
    $subject = __('mr-t.Предоставление доступа к системе') . ' ' . MrBaseHelper::MR_SITE_NAME;
    $checklist = MrOffice::loadBy($id);
    $message_text = <<< HTML
        <body>
        <h3>Здравствуйте!</h3>
<p>Вам был предоставлен доступ к виртуальному офису {$checklist->getName()} в Системе {$system}.</p>
<p>Для входа в Систему {$system} вы можете воспользоваться следующей ссылкой: {$link_login}
</p>
<p>Если Вы получили данное письмо по ошибке, проигнорируйте его.</p>
        </body>
HTML;

    $data = array(
      'user' => $user,
      'subject' => $subject,
      'message_text' => $message_text,
      'email_to' => $email,
    );

    SendReminderEmail::dispatch($data);
  }

  public static function ReSendNewUser(MrNewUsers $user)
  {
    if(MrUser::LoadUserByEmail($user->getEmail()))
    {
      self::SendNewUserRole($user->getOffice()->id(), $user->getEmail());
    }
  }
}