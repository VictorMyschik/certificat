<?php


namespace App\Models\Certificate;


use App\Models\Lego\MrObjectTrait;
use App\Models\ORM;

class MrCommunicate extends ORM
{
  use MrObjectTrait;

  public static $mr_table = 'mr_communicate';
  public static $className = MrCommunicate::class;
  protected $table = 'mr_communicate';

  protected static $dbFieldsMap = array(
    'ObjectKind',//К чему привязан
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
  public static function getObjectKindList(): array
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

  const CODE_TE = 1;
  const CODE_FX = 2;
  const CODE_EM = 3;
  const CODE_AO = 4;

  private static $address_kinds = array(
    self::CODE_TE => 'Телефон',
    self::CODE_FX => 'Факс',
    self::CODE_EM => 'Электронная почта',
    self::CODE_AO => 'URL',
  );

  private static $kind_codes = array(
    self::CODE_TE => 'TE',
    self::CODE_FX => 'FX',
    self::CODE_EM => 'EM',
    self::CODE_AO => 'AO',
  );

  public static function GetKindCodes(): array
  {
    return self::$kind_codes;
  }

  public function getKindCode(): string
  {
    return self::$kind_codes[$this->getKind()];
  }

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