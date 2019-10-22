<?php

namespace App\Http\Controllers;

use App\Models\MrUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UloginController extends Controller
{

// Login user through social network.
  public function login(Request $request)
  {
    if(!$request->get('token',null))
    {
      $out = array(
        'message' => 'Произошла ошибка авторизации.',
      );

      return redirect('/login')->with($out);
    }

    // Get information about user.
    $data = file_get_contents('http://ulogin.ru/token.php?token=' . $request->get('token',null) . '&host=' . $_SERVER['HTTP_HOST']);
    $response = json_decode($data, true);
    // Если Email отсутствует в ответе Ulogin -> возврат на /login с сообщением
    $email = $response['email'] ?? null;
    $regex = '/\S+@\S+\.\S+/';
    if(!preg_match($regex, $email))
    {
      $out = array(
        'message' => 'Отсутствует E-mail. Пожалуйста, выберите другую социальную сеть для авторизации, либо воспользуйтесь стандартной формой.',
      );

      return redirect('/login')->with($out);
    }
    // поиск пользователя в БД
    $user = MrUser::loadBy((string)$response['email'], 'Email');
    // Авторизация
    if($user)
    {
      $user->setDateLogin();
      $user->save_mr();

      Auth::loginUsingId($user->getUserLaravel()['id']);
    }
    else//// создание нового пользователя
    {
      $name = '';
      if($value = $response['first_name'])
        $name .= $value;
      if($value = $response['last_name'])
        $name .= ' ' . $value;

      if($value = $response['profile'])
      {
        $array = MrBaseHelper::cleaning(['profile' => (string)$value]);
        if(count($array))
          $profile = $array['profile'];
        else
          $profile = null;
      }

      if(strlen($name) == 0)
        $name = 'Новичок';

      $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
      $max = 7;
      $size = StrLen($chars) - 1;
      $password = null;
      while ($max--)
        $password .= $chars[rand(0, $size)];

      // Новый в Laravel
      $new_user = User::create([
        'name'     => $name,
        'email'    => $email,
        'password' => Hash::make($password),
      ]);

      $new_mr_user = new MrUser();
      $new_mr_user->setUserLaravelID($new_user->id);
      $new_mr_user->setDateFirstVisit(Carbon::now());
      $new_mr_user->setProfile($profile);
      $new_mr_user->setDateLogin();

      $new_mr_user->save_mr();

      $site = MrBaseHelper::MR_SITE;
      $subject = 'Регистрация в системе ' . $site;
      $message =
        <<< HTML
        <body>
        <h3>Здравствуйте</h3>
        <p>Вы получили это письмо, потому что зарегистрировались на сайте $site</p>
        <p>Данные для входа:</p>
        <p>E-mail: $email</p>
        <p>Пароль: $password</p>
        <p>Страница входа <a href="https:$site/login"></a></p>
        <hr>
        <h3>Если Вы ничего не делали, а Вам всё равно пришло это письмо, </h3>
        </body>
HTML;

      MrBaseHelper::SendEmail($email, $subject, $message);

      // Make login user.
      Auth::loginUsingId($new_user->id);
    }

    $user_true = MrUser::me();

    return Redirect($user_true->getPreviousUrl());

  }
}
