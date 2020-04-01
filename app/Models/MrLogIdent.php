<?php

namespace App\Models;

use App\Helpers\MrDateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/*
 * Запись данных всех посещений
 * */

class MrLogIdent extends ORM
{
  public static $mr_table = 'mr_log_ident';
  public static $className = MrLogIdent::class;
  public static $ident_id = '0';
  protected static $dbFieldsMap = array(
    'Referer',
    'Link',
    'Ip',
    'UserID',    // Если из зарегистрированных
    'UserAgent', //Браузер пользоваетля
    'City',
    'Country',
    'Cookie',
    'LanguageID',
  );

  public static function loadBy($value, $field = 'id'): ?MrLogIdent
  {
    return parent::loadBy((string)$value, $field);
  }

  public function after_save()
  {
    self::$ident_id = $this->id();
  }

  // Дата
  public function getDate(): MrDateTime
  {
    return $this->getDateNullableField('Date');
  }

  // Источник перехода
  public function getReferer(): ?string
  {
    return $this->Referer;
  }

  public function setReferer(?string $value)
  {
    $this->Referer = $value;
  }

  // Текущая ссылка
  public function getLink(): ?string
  {
    return $this->Link;
  }

  public function setLink(?string $value)
  {
    $this->Link = $value;
  }

  // Зарегестрированный пользователь
  public function getUser(): ?MrUser
  {
    return MrUser::loadBy($this->UserID);
  }

  public function setUserID(?int $value)
  {
    $this->UserID = $value;
  }

  // Ip
  public function getIp(): ?string
  {
    return $this->Ip;
  }

  public function setIp(?string $value)
  {
    $this->Ip = $value;
  }

  // Инфо о браузере посетителя
  public function getUserAgent(): ?string
  {
    return $this->UserAgent;
  }

  public function setUserAgent(?string $value)
  {
    $this->UserAgent = $value;
  }

  // Город
  public function getCity(): ?string
  {
    return $this->City;
  }

  public function setCity(?string $value)
  {
    $this->City = $value;
  }

  // Страна
  public function getCountry(): ?string
  {
    return $this->Country;
  }

  public function setCountry(?string $value)
  {
    $this->Country = $value;
  }

  // Cookie
  public function getCookie(): ?string
  {
    return $this->Cookie;
  }

  public function setCookie(?string $value)
  {
    $this->Cookie = $value;
  }

  // Cookie
  public function getLanguage(): ?MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  public function setLanguageID(?int $value)
  {
    $this->LanguageID = $value;
  }

  //////////////////////////////////////////////////////////////////////////////////////////

  public function GetFullLocation(): ?string
  {
    $r = '';

    $r .= $this->getCity();
    $r .= strlen($r) ? ' ' : '';
    $r .= $this->getCountry();

    return $r;
  }

  /**
   * @param Carbon $date
   * @param string|null $type
   * @return self[]
   */
  public static function GetAllLast(?Carbon $date, ?string $type = null): array
  {
    $out = array();

    if($date)
    {
      if($type == 'bot')
      {
        $list = DB::table(static::$mr_table)
          ->whereNotNull('BotID')
          ->WHERE('Date', '>', $date)
          ->orderBy('id', 'DESC')->get(['id']);
      }
      elseif($type == 'user')
      {
        $list = DB::table(static::$mr_table)
          ->WHERE('Date', '>', $date)
          ->whereNull('BotID')
          ->orderBy('id', 'DESC')->get(['id']);
      }
      else
      {
        $list = DB::table(static::$mr_table)
          ->WHERE('Date', '>', $date)
          ->orderBy('id', 'DESC')->get(['id']);
      }
    }
    else
    {
      $list = DB::table(static::$mr_table)->orderBy('Date', 'DESC')->get(['id']);
    }

    foreach ($list as $item)
    {
      $out[] = self::loadBy($item->id);
    }

    return $out;
  }

  /**
   * Вернуть список посещений разбитый на ботов и людей
   *
   * @param Carbon|null $date
   * @return array
   */
  public static function GetDifferentUsers(?Carbon $date): array
  {
    $out = array();
    foreach (self::GetAllLast($date) as $item)
    {
      if($item->getUser())
      {
        $out['users'][] = $item;
        $out['users_unique'][$item->getUser()->id()] = $item;
      }
      elseif($item->getBot())
      {
        $out['bot'][] = $item;
        $out['bot_unique'][$item->getBot()->id()] = $item;
      }
      else
      {
        $out['other'][] = $item;
      }
    }

    return $out;
  }
}
