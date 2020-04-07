<?php

namespace App\Models\References;

use App\Http\Controllers\Admin\MrAdminBackUpController;
use App\Models\ORM;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Данные берутся с https://www.geonames.org/countries/
 */
class MrCountry extends ORM
{
  public static $mr_table = 'mr_country';
  public static $className = MrCountry::class;

  public static function getRouteTable()
  {
    return 'list_country_table';
  }

  protected static $dbFieldsMap = array(
    'Name',
    'ISO3166alpha2',
    'ISO3166alpha3',
    'ISO3166numeric',
    'Capital',
    'Continent',
  );

  public static function loadBy($value, $field = 'id'): ?MrCountry
  {
    return parent::loadBy((string)$value, $field);
  }

  const CONTINENT_UNKNOWN = 0;
  const CONTINENT_AF = 1;
  const CONTINENT_AS = 2;
  const CONTINENT_EU = 3;
  const CONTINENT_NA = 4;
  const CONTINENT_OC = 5;
  const CONTINENT_SA = 6;
  const CONTINENT_AN = 7;

  protected static $continents = array(
    self::CONTINENT_UNKNOWN => 'Not select',
    self::CONTINENT_AF => 'Africa',
    self::CONTINENT_AS => 'Asia',
    self::CONTINENT_EU => 'Europe',
    self::CONTINENT_NA => 'North America',
    self::CONTINENT_OC => 'Oceania',
    self::CONTINENT_SA => 'South America',
    self::CONTINENT_AN => 'Antarctica',
  );

  protected static $continent_short = array(
    self::CONTINENT_AF => 'AF',
    self::CONTINENT_AS => 'AS',
    self::CONTINENT_EU => 'EU',
    self::CONTINENT_NA => 'NA',
    self::CONTINENT_OC => 'OC',
    self::CONTINENT_SA => 'SA',
    self::CONTINENT_AN => 'AN',
  );

  public static function getContinentList()
  {
    return self::$continents;
  }

  public static function getContinentShortList()
  {
    return self::$continent_short;
  }

  public function getContinent(): int
  {
    return $this->Continent;
  }

  public function getContinentName(): string
  {
    return self::$continents[$this->getContinent()];
  }

  public function getContinentShortName()
  {
    return self::$continent_short[$this->getContinent()];
  }

  public function setContinent(int $value)
  {
    $this->Continent = $value;
  }

  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  public function getISO3166alpha2(): string
  {
    return $this->ISO3166alpha2;
  }

  public function setISO3166alpha2(string $value)
  {
    $this->ISO3166alpha2 = $value;
  }

  public function getISO3166alpha3(): string
  {
    return $this->ISO3166alpha3;
  }

  public function setISO3166alpha3(string $value)
  {
    $this->ISO3166alpha3 = $value;
  }

  public function getISO3166numeric(): string
  {
    return $this->ISO3166numeric;
  }

  public function setISO3166numeric(string $value)
  {
    $this->ISO3166numeric = $value;
  }

  public function getCapital(): string
  {
    return $this->Capital;
  }

  public function setCapital(string $value)
  {
    $this->Capital = $value;
  }

  public function getCodeWithName()
  {
    $r = $this->getISO3166alpha3();
    $r .= ' ';
    $r .= $this->getName();

    return $r;
  }

}