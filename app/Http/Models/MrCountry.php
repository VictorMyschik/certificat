<?php

namespace App\Http\Models;

use App\Http\Controllers\Forms\MrMessageEditForm;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\ORM;

/**
 * Данные берутся с API http://api.travelpayouts.com/data/ru/countries.json
 *
 */
class MrCountry extends ORM
{
  public static $mr_table = 'mr_country';
  public static $className = MrCountry::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'NameRus',
    'NameEng',
    'Code',
  );

  public static function loadBy($value, $field = 'id'): ?MrCountry
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
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

      MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Импортировано ' . count($data) . ' строк');
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Удалённый сервер не вернул данные, справочник не был затронут');
    }

  }
}