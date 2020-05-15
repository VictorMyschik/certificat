<?php

namespace App\Models\Certificate;

use App\Models\MrUser;
use App\Models\ORM;
use App\Models\References\MrCountry;

class MrAddress extends ORM
{
  public static $className = MrAddress::class;
  protected $table = 'mr_address';

  protected $fillable = array(
    'AddressKind',
    'CountryID',
    'TerritoryCode',//17
    'RegionName',//120
    'DistrictName',//120
    'City', //120
    'SettlementName', //120
    'StreetName', //120
    'BuildingNumberId',//50
    'RoomNumberId',//20
    'PostCode', //max 10
    'PostOfficeBoxId', //max 20 Номер абонентского ящика
    'AddressText', //max 1000 Адрес в текстовой форме
    'Lat',
    'Lon',
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

  // Типы адресов
  const ADDRESS_KIND_REGISTRATION = 1; //адрес регистрации
  const ADDRESS_KIND_FACT = 2; //фактический адрес
  const ADDRESS_KIND_POSTAL = 3; //почтовый адрес

  public static function GetAddressKindList(): array
  {
    return array(
      self::ADDRESS_KIND_REGISTRATION => 'адрес регистрации',
      self::ADDRESS_KIND_FACT         => 'фактический адрес',
      self::ADDRESS_KIND_POSTAL       => 'почтовый адрес',
    );
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

  public function before_save()
  {

  }

  /**
   * Тип адреса
   * адрес регистрации
   * фактический адрес
   * почтовый адрес
   *
   * @return int
   */
  public function getAddressKind(): int
  {
    return $this->AddressKind;
  }

  public function getAddressKindName(): string
  {
    return self::GetAddressKindList()[$this->AddressKind];
  }

  public function setAddressKind(int $value)
  {
    if(isset(self::GetAddressKindList()[$value]))
    {
      $this->AddressKind = $value;
    }
    else
    {
      dd('Тип адреса не найден');
    }
  }

  /**
   * Страна
   *
   * @return MrCountry
   */
  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(?int $value): void
  {
    $this->CountryID = $value;
  }

  /**
   * Код территории
   *
   * @return string|null
   */
  public function getTerritoryCode(): ?string
  {
    return $this->TerritoryCode;
  }

  public function setTerritoryCode(?string $value): void
  {
    $this->TerritoryCode = $value;
  }

  /**
   * Регион
   *
   * @return string|null
   */
  public function getRegionName(): ?string
  {
    return $this->RegionName;
  }

  public function setRegionName(?string $value): void
  {
    $this->RegionName = $value;
  }

  /**
   * Наименование единицы административно-территориального деления второго уровня
   *
   * @return string|null
   */
  public function getDistrictName(): ?string
  {
    return $this->DistrictName;
  }

  public function setDistrictName(?string $value): void
  {
    $this->DistrictName = $value;
  }

  /**
   * Город
   *
   * @return string|null
   */
  public function getCity(): ?string
  {
    return $this->City;
  }

  public function setCity(?string $value): void
  {
    $this->City = $value;
  }

  /**
   * Наименование населенного пункта
   *
   * @return string|null
   */
  public function getSettlementName(): ?string
  {
    return $this->SettlementName;
  }

  public function setSettlementName(?string $value): void
  {
    $this->SettlementName = $value;
  }

  /**
   * Улица
   *
   * @return string|null
   */
  public function getStreetName(): ?string
  {
    return $this->StreetName;
  }

  public function setStreetName(?string $value): void
  {
    $this->StreetName = $value;
  }


  public function getBuildingNumberId(): ?string
  {
    return $this->BuildingNumberId;
  }

  public function setBuildingNumberId(?string $value): void
  {
    $this->BuildingNumberId = $value;
  }

  /**
   * Обозначение офиса или квартиры
   *
   * @return string|null
   */
  public function getRoomNumberId(): ?string
  {
    return $this->RoomNumberId;
  }

  public function setRoomNumberId(?string $value): void
  {
    $this->RoomNumberId = $value;
  }

  /**
   * Почтовый индекс
   *
   * @return string|null
   */
  public function getPostCode(): ?string
  {
    return $this->PostCode;
  }

  public function setPostCode(?string $value): void
  {
    $this->PostCode = $value;
  }

  /**
   * Номер абонентского ящика на предприятии почтовой связи
   *
   * @return string|null
   */
  public function getPostOfficeBoxId(): ?string
  {
    return $this->PostOfficeBoxId;
  }

  public function setPostOfficeBoxId(?string $value): void
  {
    $this->PostOfficeBoxId = $value;
  }

  /**
   * Набор элементов адреса, представленных в свободной форме в виде текста
   *
   * @return string|null
   */
  public function getAddressText(): ?string
  {
    return $this->AddressText;
  }

  public function setAddressText(?string $value): void
  {
    $this->AddressText = $value;
  }

  public function getLat(): ?string
  {
    return $this->Lat;
  }

  public function setLat(?string $value): void
  {
    $this->Lat = $value;
  }

  public function getLon(): ?string
  {
    return $this->Lon;
  }

  public function setLon(?string $value): void
  {
    $this->Lon = $value;
  }

////////////////////////////////////////////////////////////

  public function GetShortAddress()
  {
    $r = $this->getPostCode() ?: '';

    if($this->getCountry())
    {
      $r .= '(' . $this->getCountry()->getContinentShortName() . ')';
      $r .= ' ' . $this->getCountry()->getName();
    }

    $r .= ' ' . $this->getCity();

    return $r;
  }

  public function GetFullAddress()
  {
    $r = $this->getPostCode() ?: '';

    if($country = $this->getCountry())
    {
      $r .= ($r ? ', ' : '') . $country->getName();
    }

    if($this->getPostOfficeBoxId())
    {
      $r .= ($r ? ', ' : '') . 'а/я ' . $this->getPostOfficeBoxId();
    }

    if($this->getRegionName())
    {
      $r .= ($r ? ', ' : '') . $this->getRegionName();
    }

    if($this->getDistrictName())
    {
      $r .= ($r ? ', ' : '') . $this->getDistrictName();
    }

    if($this->getCity())
    {
      $r .= ($r ? ', ' : '') . $this->getCity();
    }

    if($this->getSettlementName())
    {
      $r .= ($r ? ', ' : '') . $this->getSettlementName();
    }

    if($this->getStreetName())
    {
      $r .= ($r ? ', ' : '') . $this->getStreetName();
    }

    if($this->getBuildingNumberId())
    {
      $r .= ($r ? ', ' : '') . $this->getBuildingNumberId();
    }

    if($this->getRoomNumberId())
    {
      $r .= ($r ? ', ' : '') . $this->getRoomNumberId();
    }

    if($this->getAddressText())
    {
      $r .= ($r ? ', ' : '') . $this->getAddressText();
    }

    return $r;
  }
}