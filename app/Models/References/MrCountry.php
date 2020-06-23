<?php

namespace App\Models\References;

use App\Models\ORM;

/**
 * Данные берутся https://www.geonames.org/countries/
 */
class MrCountry extends ORM
{
  protected $table = 'mr_country';
  public static $className = MrCountry::class;
  protected $primaryKey = 'id';

  public static function getRouteTable()
  {
    return 'list_country_table';
  }

  protected $fillable = array(
      'Name',
      'ISO3166alpha2',
      'ISO3166alpha3',
      'ISO3166numeric',
      'Continent',
  );

  public static function getReferenceInfo()
  {
    return array(
        'classifier_group' => 'Классификаторы для заполнения таможенных деклараций',
        'description'      => 'классификатор предназначен для классификации и кодирования информации о наименованиях стран мира',
        'date'             => '30.09.2016',
        'document'         => 'О классификаторах, используемых для заполнения таможенных деклараций Решение №378 (имеются изменения и дополнения: Решения Комиссии Таможенного союза №№ 441, 719, 858, 906, Решение Совета Евразийской экономической комиссии № 9)',
        'doc_link'         => 'https://docs.eaeunion.org/_layouts/15/Portal.EEC.NPB/Pages/RedirectToDisplayForm.aspx?mode=Document&UseSearch=1&docId=6690653a-2f1d-4428-b6fc-cf43fa5d4095',
    );
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
      self::CONTINENT_AF      => 'Africa',
      self::CONTINENT_AS      => 'Asia',
      self::CONTINENT_EU      => 'Europe',
      self::CONTINENT_NA      => 'North America',
      self::CONTINENT_OC      => 'Oceania',
      self::CONTINENT_SA      => 'South America',
      self::CONTINENT_AN      => 'Antarctica',
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

  public function setContinent(int $value): void
  {
    $this->Continent = $value;
  }

  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value): void
  {
    $this->Name = $value;
  }

  public function getISO3166alpha2(): string
  {
    return $this->ISO3166alpha2;
  }

  public function setISO3166alpha2(string $value): void
  {
    $this->ISO3166alpha2 = $value;
  }

  public function getISO3166alpha3(): string
  {
    return $this->ISO3166alpha3;
  }

  public function setISO3166alpha3(string $value): void
  {
    $this->ISO3166alpha3 = $value;
  }

  public function getISO3166numeric(): string
  {
    return $this->ISO3166numeric;
  }

  public function setISO3166numeric(string $value): void
  {
    $this->ISO3166numeric = $value;
  }

  public function getCodeWithName()
  {
    $r = $this->getISO3166alpha2();
    $r .= ' ';
    $r .= __('mr-t.' . $this->getName());

    return $r;
  }

  public static function SelectList()
  {
    $out = array();
    foreach (self::all() as $item)
    {
      $out[$item->id()] = __('mr-t.' . $item->getName());
    }
    return $out;
  }

  public function GetCodeWithTitleName(): string
  {
    $title = __('mr-t.' . $this->getName());

    return "<span title={$title}>{$this->getISO3166alpha2()}</span>";
  }
}