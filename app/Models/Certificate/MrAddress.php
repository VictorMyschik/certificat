<?php


namespace App\Models\Certificate;


use App\Models\MrUser;
use App\Models\ORM;
use App\Models\References\MrCountry;

class MrAddress extends ORM
{
  public static $mr_table = 'mr_address';
  public static $className = MrAddress::class;

  protected static $dbFieldsMap = array(
    'ObjectKind',
    'ObjectID',
    'CountryID',
    'City',
    'Building',
    'Address',
    'Lat',
    'Lon',
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

  public function getObjectKindName(): string
  {
    return self::getObjectKindList()[$this->getObjectKind()];
  }

  public function getObjectKindModelName(): string
  {
    return self::getKindObjectModelList()[$this->getObjectKind()];
  }

  public function getObjectKind(): int
  {
    return $this->ObjectKind;
  }

  public function setObjectKind(int $value)
  {
    if(isset(self::getKindObjectModelList()[$value]))
    {
      $this->ObjectKind = $value;
    }
    else
    {
      dd($value . 'Тип объекта привязки не известен');
    }
  }

  public static function loadBy($value, $field = 'id'): ?MrAddress
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canView()
  {
    $user = MrUser::me();
    if($user->IsSuperAdmin())
    {
      return true;
    }

    return false;
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
  public function getCountry(): MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(int $value)
  {
    $this->CountryID = $value;
  }

  public function getCity(): ?string
  {
    return $this->City;
  }

  public function setCity(?string $value)
  {
    $this->City = $value;
  }

  public function getBuilding(): ?string
  {
    return $this->Building;
  }

  public function setBuilding(?string $value)
  {
    $this->Building = $value;
  }

  public function getAddress(): ?string
  {
    return $this->Address;
  }

  public function setAddress(?string $value)
  {
    $this->Address = $value;
  }

  public function getLat(): ?string
  {
    return $this->Lat;
  }

  public function setLat(?string $value)
  {
    $this->Lat = $value;
  }

  public function getLon(): ?string
  {
    return $this->Lon;
  }

  public function setLon(?string $value)
  {
    $this->Lon = $value;
  }

////////////////////////////////////////////////////////////

  public function GetFullAddress()
  {
    $r = '';
    $r .= '(' . $this->getCountry()->getContinentShortName() . ')';
    $r .= ' ' . $this->getCountry()->getName();
    $r .= ' ' . $this->getCity();
    $r .= ' ';
    $r .= $this->getAddress();

    return $r;
  }
}