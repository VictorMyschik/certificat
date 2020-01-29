<?php

namespace App\Http\Models;

use App\Http\Controllers\Helpers\MrMessageHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Данные берутся с API http://api.travelpayouts.com/data/ru/countries.json
 *
 */
class MrCountry extends ORM
{
  public static $mr_table = 'mr_country';
  public static $className = MrCountry::class;

  protected static $dbFieldsMap = array(
    'NameRus',
    'NameEng',
    'Code',
    'NumericCode'
  );

  public static function loadBy($value, $field = 'id'): ?MrCountry
  {
    return parent::loadBy((string)$value, $field);
  }

  public function getNameRus(): ?string
  {
    return $this->NameRus;
  }

  public function setNameRus(?string $value)
  {
    $this->NameRus = $value;
  }

  public function getNameEng(): ?string
  {
    return $this->NameEng;
  }

  public function setNameEng(?string $value)
  {
    $this->NameEng = $value;
  }

  public function getCode(): ?string
  {
    return $this->Code;
  }

  public function setCode(?string $value)
  {
    $this->Code = $value;
  }

  public function getNumericCode(): ?string
  {
    return $this->NumericCode;
  }

  public function setNumericCode(?string $value)
  {
    $this->NumericCode = $value;
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Переустановка справочника стран
   */
  public static function RebuildReference()
  {
    $data = @json_decode(file_get_contents('http://api.travelpayouts.com/data/ru/countries.json'), true);
    if(count($data))
    {
      MrCountry::AllDelete();

      foreach ($data as $item)
      {
        $new = new MrCountry();
        $new->setCode($item['code']);
        $new->setNameRus($item['name']);
        $new->setNameEng($item['name_translations']['en']);

        $new->save_mr();
      }

      MrMessageHelper::SetMessage(true, 'Импортировано ' . count($data) . ' строк');
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Удалённый сервер не вернул данные, справочник не был затронут');
    }
  }

  public function getCodeWithName()
  {
    $r = $this->getCode();
    $r .= ' ';
    $r .= $this->getNameRus();

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
}