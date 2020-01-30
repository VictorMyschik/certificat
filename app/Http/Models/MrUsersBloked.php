<?php

namespace App\Http\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrUsersBloked extends ORM
{
  public static $mr_table = 'mr_users_bloked';
  public static $className = MrUsersBloked::class;

  protected static $dbFieldsMap = array(
    'UserID',
    'DateFrom',
    'DateTo',
    'Description',
  );

  public static function loadBy($value, $field = 'id'): ?MrUsersBloked
  {
    return parent::loadBy((string)$value, $field);
  }

  public function getUser(): ?MrUser
  {
    return MrUser::loadBy((int)$this->UserID);
  }

  public function setUserID(int $value)
  {
    $this->UserID = $value;
  }

  // Дата начала блокировки
  public function getDateFrom(): Carbon
  {
    return new Carbon($this->DateFrom);
  }

  public function setDateFrom()
  {
    $this->DateFrom = Carbon::now();
  }

  // Дата окончания
  public function getDateTo(): Carbon
  {
    return new Carbon($this->DateTo);
  }

  public function setDateTo(Carbon $value)
  {
    $this->DateTo = $value;
  }

  // Описание
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

////////////////////////////////////////////////////////////////
  public static function GetAll()
  {
    $list = DB::table(static::$mr_table)->get(['id']);
    $out = array();
    foreach ($list as $id)
    {
      $out[] = self::loadBy($id->id);
    }

    return $out;
  }

  /**
   * Список всех заблокированых пользователей
   *
   * @return self[]
   */
  public static function GetAllBlocked()
  {
    $list = DB::table(static::$mr_table)->where('DateTo','>', Carbon::now())->get(['id']);
    $out = array();
    foreach ($list as $id)
    {
      $out[] = self::loadBy($id->id);
    }

    return $out;
  }
}