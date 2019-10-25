<?php


namespace App\Http\Controllers\Helpers;

/*
 * Общие методы для всего проекта
 * */

use App\Http\Controllers\Controller;

abstract class MrBaseHelper extends Controller
{
  const MR_EMAIL = 'allximik@gmail.com';
  const MR_SITE_NAME = 'SiteName';
  const MR_DOMAIN = 'certificat';
  const MR_SITE = 'certificat';
  const MR_SITE_URL = 'http://certificat/';
  const ADMIN_PHONE = '375297896282';
  const ADMIN_TELEGRAM = 'tg://resolve?domain=Allximik50';
  const ADMIN_VIBER = 'viber://chat?number=375297896282';

  /**
   * очистка от инъекций и прочего
   *
   * @param array|null $data
   * @return array
   */
  public static function cleaning(array $data = null): array
  {
    $clean = array();
    if($data)
    {
      foreach ($data as $key => $value)
      {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $clean[$key] = $value;
      }

      return $clean;
    }

    if(count($_REQUEST))
    {
      foreach ($_REQUEST as $key => $value)
      {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $clean[$key] = $value;
      }

      return $clean;
    }

    return $clean;
  }


  /**
   * перевод строки в float
   *
   * @param $str
   * @return float|null
   */
  public static function toFloat($str): ?float
  {
    if(is_float($str))
    {
      return $str;
    }

    if(is_null($str))
    {
      return null;
    }

    if(is_int($str))
    {
      return (float)$str;
    } //casting int to float is always safe

    //убираем все пробелы
    $str = preg_replace('/\s/', '', $str);

    //точки заменяем на запятые
    $str = preg_replace('/\./', ',', $str);

    //leave only last point
    $l = strlen($str);
    $last_point = -1;
    for ($i = 0; $i < $l; $i++)
    {
      if($str[$i] == ',')
      {
        $last_point = $i;
      }
    }

    if($last_point >= 0)
    {
      $str[$last_point] = '.';
    }

    $str = preg_replace('/\,/', '', $str);

    if(is_numeric($str))
    {
      return (float)$str;
    }
    else
    {
      return null;
    }
  }

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

  public static function formatMoney(string $value): ?string
  {
    if(!$value)
    {
      return null;
    }

    return number_format($value, 2, '.', ' ');
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
}
