<?php

namespace App\Models;

/*
 * Список ботов
 * */

use Illuminate\Support\Facades\DB;

class MrBotUserAgent extends ORM
{
  public static $mr_table = 'mr_bot_useragent';
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'UserAgent',   //Браузер пользоваетля
    'Description', //Описание
  );

  public static function loadBy($value, $field = 'id'): ?MrBotUserAgent
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public function getUserAgent(): string
  {
    return $this->UserAgent;
  }

  public function setUserAgent(?string $value)
  {
    $this->UserAgent = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }
  /////////////////////////////////////////////////////////

  /**
   * @return self[]
   */
  public static function GetAll():array
  {
    $out = array();
    $list = DB::table(static::$mr_table)->pluck('id');
    foreach ($list as $item)
    {
      $out[] = MrBotUserAgent::loadBy($item);
    }
    return $out;
  }
}
