<?php


namespace App\Models\Certificate;


use App\Models\ORM;

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

  /**
   * Модли привязки адреса на экран
   *
   * @return array
   */
  public static function getKindObjectList(): array
  {
    return array(
      self::KIND_OBJECT_MANUFACTURER => 'Производитель',
    );
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

  public function getKindObjectName(): string
  {
    return self::getKindObjectList()[$this->getKindObject()];
  }

  public function getKindObjectModelName(): string
  {
    return self::getKindObjectModelList()[$this->getKindObject()];
  }

  public function getKindObject(): int
  {
    return $this->KindObject;
  }

  public function setKindObject(int $value)
  {
    if(isset(self::getKindObjectModelList()[$value]))
    {
      $this->KindObject = $value;
    }
    else
    {
      dd($value . 'Тип объекта привязки не известен');
    }
  }


  const KIND_ADDRESS_PHONE = 1;
  const KIND_ADDRESS_EMAIL = 2;

  private static $address_kinds = array(
    self::KIND_ADDRESS_PHONE => 'Телефон',
    self::KIND_ADDRESS_EMAIL => 'Email',
  );

  public static function getAddressKinds()
  {
    return self::$address_kinds;
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
    return self::getAddressKinds()[$this->Kind];
  }

  public function setKind(int $value)
  {
    if(self::getAddressKinds()[$value])
    {
      $this->Kind = $value;
    }
    else
    {
      abort('Неизвестное значение: ' . $value);
    }
  }

  // Загрузка объекта
  public function getObject()
  {
    $class_name = $this->getKindObjectModelName();
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