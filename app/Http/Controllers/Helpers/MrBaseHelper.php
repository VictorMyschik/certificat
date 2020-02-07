<?php


namespace App\Http\Controllers\Helpers;

/*
 * Общие методы для всего проекта
 * */

use App\Http\Controllers\Controller;

abstract class MrBaseHelper extends Controller
{
  const MR_EMAIL = 'support@cardbox.ml';
  const MR_SITE_NAME = 'Certificate';
  const MR_DOMAIN = 'certificat';
  const MR_SITE = 'SiteName.ml';
  const MR_SITE_URL = 'https://certificat.ml';

  const ADMIN_PHONE = '375297896282';
  const ADMIN_PHONE_FORMAT = '+375(29)789-62-82';
  const ADMIN_TELEGRAM = 'tg://resolve?domain=Allximik50';
  const TELEGRAM_BOT = '@Allximik_bot';
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


  public static function RandomString($length = 10): string
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

  public static function RandomNumberString($length = 5): string
  {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
      $randomString .= $characters[rand(0, 9)];
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

  public static function GetQRCode()
  {
    return;
  }
}


