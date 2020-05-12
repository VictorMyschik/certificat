<?php

namespace App\Models;

use App\Helpers\MrDateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrUserBlocked extends ORM
{
  protected $table = 'mr_user_blocked';
  public static $className = MrUserBlocked::class;

  protected static $dbFieldsMap = array(
    'UserID',
    'DateFrom',
    'DateTo',
    'Description',
  );

  public function getUser(): ?MrUser
  {
    return MrUser::loadBy((int)$this->UserID);
  }

  public function setUserID(int $value)
  {
    $this->UserID = $value;
  }

  // Дата начала блокировки
  public function getDateFrom(): MrDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom(): void
  {
    $this->setDateNullableField('DateTo', MrDateTime::now());
  }

  // Дата окончания
  public function getDateTo(): MrDateTime
  {
    return $this->getDateNullableField('DateTo');
  }

  public function setDateTo(Carbon $value): void
  {
    $this->setDateNullableField('DateTo', $value);
  }

  // Описание
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

////////////////////////////////////////////////////////////////

  /**
   * Список всех заблокированных пользователей
   *
   * @return self[]
   */
  public static function GetAllBlocked()
  {
    $list = DB::table(static::getTableName())->where('DateTo', '>', Carbon::now())->get(['id']);
    $out = array();
    foreach ($list as $id)
    {
      $out[] = self::loadBy($id->id);
    }

    return $out;
  }
}