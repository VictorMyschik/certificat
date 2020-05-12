<?php

namespace App\Models;

use App\Helpers\MrBaseHelper;
use App\Helpers\MrDateTime;
use App\Models\Office\MrOffice;

/**
 * Приглашённый пользователь
 */
class MrNewUsers extends ORM
{
  protected $table = 'mr_new_users';
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
    return $this->canEdit();
  }

  public function canEdit(): bool
  {
    $me = MrUser::me();

    if($me->IsSuperAdmin())
    {
      return true;
    }

    foreach ($this->getOffice()->GetUsers() as $uio)
    {
      $user = $uio->getUser();

      if($user->id() == $me->id() && $uio->getIsAdmin())
      {
        return true;
      }
    }

    return false;
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
  public function getWriteDate(): MrDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }
//////////////////////////////////////////////////////////////////////////////

  /**
   * Генерация ссылки для добавления нового пользователя
   *
   * @param string $soul
   * @return string
   */
  public static function GetLinkForNewUser(string $soul)
  {
    $link = MrBaseHelper::MR_SITE_URL;

    $link .= '/newuser/' . $soul;

    return $link;
  }
}