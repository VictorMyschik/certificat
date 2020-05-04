<?php

namespace App\Models\Certificate;

use App\Helpers\MrCacheHelper;
use App\Models\Lego\MrAddressTrait;
use App\Models\MrUser;
use App\Models\ORM;
use App\Models\References\MrCountry;
use Illuminate\Support\Facades\DB;

class MrManufacturer extends ORM
{
  use MrAddressTrait;

  public static $mr_table = 'mr_manufacturer';
  public static $className = MrManufacturer::class;
  protected $table = 'mr_manufacturer';

  protected static $dbFieldsMap = array(
    'CountryID',
    'Name',
    'Address1ID',
    'Address2ID',
  );

  public static function loadBy($value, $field = 'id'): ?MrManufacturer
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  /**
   * Страна производителя
   */
  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(?int $value)
  {
    $this->CountryID = $value;
  }

  /**
   * Наименование
   *
   * @return string
   */
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  //////////////////////////////////////////////////////

  /**
   * Список товаров
   *
   * @return MrProduct[]
   */
  public function GetProducts(): array
  {
    return MrCacheHelper::GetCachedObjectList('product' . '_' . $this->id() . '_list', MrProduct::class, function () {
      return DB::table(MrProduct::$mr_table)->where('ManufacturerID', $this->id())->pluck('id')->toArray();
    });
  }
}