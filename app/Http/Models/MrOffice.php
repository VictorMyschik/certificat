<?php


namespace App\Http\Models;


use App\Models\MrUser;
use App\Models\ORM;
use Carbon\Carbon;

class MrOffice extends ORM
{
  public static $mr_table = 'mr_office';
  public static $className = MrOffice::class;
  protected static $dbFieldsMap = array(
    'Name',
    'AdminID',
    'TariffID',
    'Description',    // Если из зарегистрированных
    'CreateDate'
  );

  public static function loadBy($value, $field = 'id'): ?MrOffice
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }


  // Админ офиса
  public function getAdmin(): MrUser
  {
    return $this->GetObject((int)$this->AdminID, MrUser::class);
  }

  public function setAdminID(?int $value)
  {
    $this->AdminID = $value;
  }


  // Описание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  // Наименование офиса
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  // Дата создания офиса
  public function getCreateDate(): Carbon
  {
    return new Carbon($this->CreateDate);
  }
}