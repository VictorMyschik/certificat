<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;

class MrNewUsers extends ORM
{
  public static $mr_table = 'mr_new_users';
  public static $className = MrNewUsers::class;

  protected static $dbFieldsMap = array(
    'Email',
    'UserID',
    'Code',
    'OfficeID',
    'IsAdmin',
    // 'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrNewUsers
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canDelete(): bool
  {
    return true;
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value)
  {
    $this->Email = $value;
  }

  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value)
  {
    $this->Code = $value;
  }

  public function getUser(): MrUser
  {
    return MrUser::loadBy($this->UserID);
  }

  public function setUserID(int $value)
  {
    return $this->UserID = $value;
  }

  public function getOffice(): MrOffice
  {
    return MrOffice::loadBy($this->OfficeID);
  }

  public function setOfficeID(int $value)
  {
    $this->OfficeID = $value;
  }

  public function getIsAdmin(): bool
  {
    return $this->IsAdmin;
  }

  public function setIsAdmin(bool $value)
  {
    return $this->IsAdmin = $value;
  }

  // Дата создания/обновления записи
  public function getWriteDate(): MtDateTime
  {
    return $this->getDateNullableField($this->WriteDate);
  }
}