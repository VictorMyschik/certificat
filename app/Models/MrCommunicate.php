<?php


namespace App\Models;


class MrCommunicate extends ORM
{
  public static $mr_table = 'mr_communicate';
  public static $className = MrCommunicate::class;
  protected $table = 'mr_communicate';

  protected static $dbFieldsMap = array(
    'KindObject',//К чему привязан
    'ObjectID',//ID объекта
    'Kind',// Тип: телефон, email, факс...
    'Address',
  );

  const KIND_OBJECT_MANUFACTURER = 1;

  protected static $kind_object_list = array(
    self::KIND_OBJECT_MANUFACTURER => 'MrManufacturer',
  );

  public function getKindObject(): int
  {
    return $this->KindObject;
  }

  public function setKindObject(int $value)
  {
    $this->KindObject = $value;
  }

  const KIND_PHONE = 1;
  const KIND_EMAIL = 2;

  private static $kinds = array(
    self::KIND_PHONE => 'Телефон',
    self::KIND_EMAIL => 'Email',
  );

  public static function getKinds()
  {
    return self::$kinds;
  }


  public static function loadBy($value, $field = 'id'): ?MrCommunicate
  {
    return parent::loadBy((string)$value, $field);
  }

  public function getKind(): int
  {
    return $this->Kind;
  }

  public function getKindName(): string
  {
    return self::getKinds()[$this->Kind];
  }

  public function setKind(int $value)
  {
    if(self::getKinds()[$value])
    {
      $this->Kind = $value;
    }
    else
    {
      abort('Неизвестное значение: ' . $value);
    }
  }

// Загрузка объекта
  public function getObject(): object
  {
    $class = $this->Object;
    return $class::loadBy($this->ObjectID);
  }

  public function setObjectID(int $value)
  {
    $this->ObjectID = $value;
  }

// Адрес
  public function getAddress(): string
  {
    return $this->Address;
  }

  public function setAddress(string $value)
  {
    $this->Address = $value;
  }
}