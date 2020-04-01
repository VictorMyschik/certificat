<?php


namespace App\Models;


class MrAddresses extends ORM
{
  public static $mr_table = 'mr_addresses';
  public static $className = MrAddresses::class;

  protected static $dbFieldsMap = array(
    'CountryID',
    'City',
    'Building',
    'Address',
    'Lat',
    'Lon',
  );

  public static function loadBy($value, $field = 'id'): ?MrAddresses
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

  public function getLon(): string
  {
    return $this->Lon;
  }

  public function setLon(string $value)
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