<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrUser;
use Illuminate\Http\Request;

class MrAddOfficeUserForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['Email'] = array(
      '#type' => 'email',
      '#title' => 'Email',
      '#value' => '',
    );

    $form['IsAdmin'] = array(
      '#type' => 'checkbox',
      '#title' => 'Администратор',
      '#value' => 0,
    );

    $form[] = '<p><i class="fa fa-info-circle mr-color-green"></i> На электронный адрес придёт ссылка на активацию акаунта</p>';

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

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

    $user = MrUser::me();

    $uio = new MrNewUsers();
    $uio->setEmail($v['Email']);
    $uio->setUserID($user->id());
    $uio->setIsAdmin((bool)(isset($v['IsAdmin']) && $v['IsAdmin']));

    $uio->save_mr();


    $email_to = $v['Email'];
    $subject = "Новый пользователь в системе " . MrBaseHelper::MR_SITE_NAME;
    $message =
      <<< HTML
        <body>
        <h3>Здравствуйте!</h3>
<p>Для аккаунта с адресом {$v['Email']} был предоставлен доступ в Виртуальный Офис {$user->getDefaultOffice()->getName()} в Системе .</p>
<p>Для входа в Систему {MrBaseHelper::MR_SITE_NAME} вы можете воспользоваться следующей ссылкой:
</p>
<p>Если Вы получили данное письмо по ошибке, проигнорируйте его.</p>
        </body>
HTML;
    $status = MrBaseHelper::SendEmail($email_to, $subject, $message);
    MrMessageHelper::SetMessage(true, $status);
    return;
  }
}