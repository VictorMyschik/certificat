<?php


namespace App\Http\Controllers\Helpers;

/*
 * Общие методы для всего проекта
 * */

use App\Http\Controllers\Controller;

abstract class MrBaseHelper extends Controller
{
  const MR_EMAIL = 'support@cardbox.ml';
  const MR_SITE_NAME = 'SiteName';
  const MR_DOMAIN = 'certificat';
  const MR_SITE = 'SiteName.ml';
  const MR_SITE_URL = 'http://certificat';

  const ADMIN_PHONE = '375297896282';
  const ADMIN_TELEGRAM = 'tg://resolve?domain=Allximik50';
  const ADMIN_VIBER = 'viber://chat?number=375297896282';

  /**
   * Генератор коротких ссылок
   *
   * @param null $url
   * @return null|string
   */
  public static function GetShortLink($url = null): ?string
  {
    if(!$url)
    {
      return null;
    }

    //если ничего не вернуло, то вернуть длинную ссылку
    if($new_link = file_get_contents("https://clck.ru/--?url=" . $url))
    {
      return $new_link;
    }
    else
    {
      return $url;
    }
  }

  public static function SendEmail(string $email_to, string $subject, string $message): bool
  {
    $regex = '/\S+@\S+\.\S+/';
    if(!preg_match($regex, $email_to))
    {
      return false;
    }
    /*
        $message =
          <<< HTML
        <body>
        <p>Имя: $data[name]</p>
        <p>Почта: $data[email]</p>
        <p>Сообщение: $data[text]</p>
        </body>
    HTML;
    */
    $headers = "Content-type: text/html; charset=UTF8 \r\n";
    $headers .= "From: " . MrBaseHelper::MR_EMAIL . "\r\n";

    $status = mail($email_to, $subject, $message, $headers);

    return $status;
  }

  public static function RandomString($length = 10)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  //regex for phone 'Phone' => ["nullable", "regex:/^\+375\((17|29|33|44)\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/"],
  /*
    <script type="text/javascript">
          jQuery(function ($) {
            $("#phone").mask("+999(99)999-99-99");
          });
        </script>
   * */

  public static function sendMeByTelegram($text)
  {
    // сюда нужно вписать токен вашего бота
    define('TELEGRAM_TOKEN', '906843257:AAFJRFj08A1uEq2QtDo3iFRWSIK3vIm6CUg');

    // сюда нужно вписать ваш внутренний айдишник
    define('TELEGRAM_CHATID', '488545536');


    $ch = curl_init();
    curl_setopt_array(
      $ch,
      array(
        CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => array(
          'chat_id' => TELEGRAM_CHATID,
          'text' => $text,
        ),
      )
    );
    curl_exec($ch);
  }

  /**
   * Генерация ссылки для добавления нового пользователя
   *
   * @param string $soul
   * @return string
   */
  public static function GetLinkForNewUser(string $soul)
  {
    $link = self::MR_SITE_URL;

    $link .= '/newuser/' . $soul;

    return $link;
  }
}


