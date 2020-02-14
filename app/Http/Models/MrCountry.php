<?php

namespace App\Http\Models;

use App\Http\Controllers\Admin\MrAdminBackUpController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Данные берутся с https://www.geonames.org/countries/
 *
 */
class MrCountry extends ORM
{
  public static $mr_table = 'mr_countries';
  public static $className = MrCountry::class;

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

  ///////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Переустановка справочника стран
   */
  public static function RebuildReference()
  {
    $data = MrAdminBackUpController::$tables['mr_country'];
    foreach ($data as $v)
    {
      $country = MrCountry::loadBy($v[2], 'ISO3166alpha2') ?: new MrCountry();
      $country->setName($v[1]);
      $country->setISO3166alpha2($v[2]);
      $country->setISO3166alpha3($v[3]);
      $country->setISO3166numeric($v[4]);
      $country->setCapital($v[5]);
      $continent = array_search($v[6], MrCountry::getContinentShortList());
      $country->setContinent($continent);
      $country->save_mr();
    }
  }

  public function getCodeWithName()
  {
    $r = $this->getISO3166alpha3();
    $r .= ' ';
    $r .= $this->getName();

    return $r;
  }

  /**
   * список стран для выпадушки
   *
   * @return mixed
   */
  public static function SelectList()
  {
    return Cache::rememberForever('country_list', function () {
      {
        $out = array();
        $list = DB::table(MrCountry::$mr_table)->get(['id', 'Code', 'NameRus']);
        foreach ($list as $country)
        {
          $out[$country->id] = $country->Code . ' ' . $country->NameRus;
        }
        return $out;
      }
    });
  }

  /**
   * Список городов для страны
   *
   * @return array
   */
  public function GetAddresses(): array
  {
    $list = DB::table(MrAddresses::$mr_table)->where('CountryID', $this->id())->get();
    return parent::LoadArray($list, MrAddresses::class);
  }

  public static function getSelectList()
  {
    $out = array();
    $list = DB::table(self::$mr_table)->get(['id', 'Name']);

    foreach ($list as $item)
    {
      $out[$item->id] = $item->Name;
    }

    return $out;
  }
}