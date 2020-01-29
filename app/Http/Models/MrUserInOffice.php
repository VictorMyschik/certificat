<?php


namespace App\Http\Models;


class MrUserInOffice extends ORM
{
  public static $mr_table = 'mr_user_in_office';
  public static $className = MrUserInOffice::class;
  protected static $dbFieldsMap = array(
    'UserID',
    'OfficeID',
    'IsAdmin',
    //'CreateDate'
  );

  public static function loadBy($value, $field = 'id'): ?MrUserInOffice
  {
    return parent::loadBy((string)$value, $field);
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
    return $this->OfficeID = $value;
  }

  public function getIsAdmin(): bool
  {
    return $this->IsAdmin;
  }

  public function setIsAdmin(bool $value)
  {
    return $this->IsAdmin = $value;
  }


  /**
   * Может ли админ сложить полномочия
   */
  public function canAdminChange():bool
  {
    if($this->getIsAdmin() == false)
    {
      return false;
    }

    foreach ($this->getOffice()->GetUsers() as $uio)
    {
      if($this->getUser()->id() == $uio->getUser()->id())
        continue;

      if($uio->getIsAdmin())
      {
        return true;
      }
    }

    return false;
  }

}