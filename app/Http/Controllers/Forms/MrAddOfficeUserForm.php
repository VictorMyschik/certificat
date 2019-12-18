<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Http\Controllers\Helpers\MrEmailHelper;
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
    $uio->setOfficeID($user->getDefaultOffice()->id());
    $uio->setIsAdmin((bool)(isset($v['IsAdmin']) && $v['IsAdmin']));

    $uio_id = $uio->save_mr();


    $email_to = $v['Email'];
    $system = MrBaseHelper::MR_SITE_NAME;

    $link = MrBaseHelper::GetLinkForNewUser($uio_id);

    $subject = "Новый пользователь в системе " . MrBaseHelper::MR_SITE_NAME;
    $message =
      <<< HTML
        <body>
        <h3>Здравствуйте!</h3>
<p>Для аккаунта с адресом {$email_to} был предоставлен доступ в Виртуальный Офис {$user->getDefaultOffice()->getName()} в Системе {$system}.</p>
<p>Для входа в Систему {$system} вы можете воспользоваться следующей ссылкой: {$link}
</p>
<p>Если Вы получили данное письмо по ошибке, проигнорируйте его.</p>
        </body>
HTML;
    MrEmailHelper::SendNewUser($email_to, $subject, $message);
    return;
  }
}