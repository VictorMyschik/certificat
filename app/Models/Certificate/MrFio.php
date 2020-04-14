<?php


namespace App\Models\Certificate;


use App\Models\Lego\MrObjectTrait;
use App\Models\MrUser;
use App\Models\ORM;

class MrFio extends ORM
{
  use MrObjectTrait;

  public static $mr_table = 'mr_fio';
  public static $className = MrFio::class;
  protected $table = 'mr_fio';

  protected static $dbFieldsMap = array(
    'ObjectKind',//К чему привязан
    'ObjectID',//ID объекта
    'FirstName',//Имя max 120
    'MiddleName',//Отчество max 120
    'LastName', //Фамилия max 120
    'PositionName' //Должность max 120
  );

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  const KIND_OBJECT_MANUFACTURER = 1;

  /**
   * Модли привязки адреса на экран
   *
   * @return array
   */
  public static function getObjectKindList(): array
  {
    return array(
      self::KIND_OBJECT_MANUFACTURER => 'Производитель',
    );
  }

  public static function loadBy($value, $field = 'id'): ?MrFio
  {
    return parent::loadBy((string)$value, $field);
  }

  /**
   * Модли привязки адреса
   *
   * @return array
   */
  public static function getKindObjectModelList(): array
  {
    return array(
      self::KIND_OBJECT_MANUFACTURER => 'MrManufacturer',
    );
  }


  // Загрузка объекта
  public function getObject()
  {
    $class_name = $this->getObjectKindModelName();
    if(class_exists("App\\Models\\Certificate\\" . $class_name))
    {
      $class = "App\\Models\\Certificate\\" . $class_name;

      return $class::loadBy($this->ObjectID);
    }
    else
    {
      dd('Класс не найден');
    }
  }

  public function setObjectID(int $value)
  {
    $this->ObjectID = $value;
  }

  /**
   * Имя
   *
   * @return string|null
   */
  public function getFirstName(): ?string
  {
    return $this->FirstName;
  }

  public function setFirstName(?string $value)
  {
    $this->FirstName = $value;
  }

  /**
   * Отчество
   *
   * @return string|null
   */
  public function getMiddleName(): ?string
  {
    return $this->MiddleName;
  }

  public function setMiddleName(?string $value)
  {
    $this->MiddleName = $value;
  }

  /**
   * Фамилия
   *
   * @return string|null
   */
  public function getLastName(): ?string
  {
    return $this->LastName;
  }

  public function setLastName(?string $value)
  {
    $this->LastName = $value;
  }

  /**
   * Должность
   *
   * @return string|null
   */
  public function getPositionName(): ?string
  {
    return $this->PositionName;
  }

  public function setPositionName(?string $value)
  {
    $this->PositionName = $value;
  }

  public function GetFullName(): string
  {
    $r = '';

    $r .= $this->getFirstName();
    $r .= strlen($r) ? ' ' : '' . $this->getMiddleName();
    $r .= strlen($r) ? ' ' : '' . $this->getLastName();

    return $r;
  }

}