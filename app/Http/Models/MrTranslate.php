<?php


namespace App\Http\Models;


use Illuminate\Support\Facades\DB;

class MrTranslate extends ORM
{
  public static $mr_table = 'mr_translate';
  public static $className = MrTranslate::class;

  protected static $dbFieldsMap = array(
    'Name',
    'LanguageID',
    'Translate',
  );

  public static function loadBy($value, $field = 'id'): ?MrTranslate
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  /**
   *  На русском
   *
   * @return string|null
   */
  public function getName(): ?string
  {
    return $this->Name;
  }


  public function setName(string $value)
  {
    $this->Name = $value;
  }

  public function getLanguage(): MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  /**
   * Язык перевода
   *
   * @param string $value
   */
  public function setLanguageID(string $value)
  {
    $this->LanguageID = $value;
  }

  /**
   * Переведено
   *
   * @return string|null
   */
  public function getTranslate(): ?string
  {
    return $this->Translate;
  }

  public function setTranslate(string $value)
  {
    $this->Translate = $value;
  }


  /**
   * Загрузка массива MrTranslate для одного языка
   *
   * @param MrLanguage $lg
   * @return MrTranslate[]
   */
  public static function GetByLg(MrLanguage $lg): array
  {
    $list = DB::table(MrTranslate::$mr_table)->where('LanguageID', '=', $lg->id())->get();

    return parent::LoadArray($list, MrTranslate::class);
  }

  /**
   * Вывод массива слов для одного языка
   *
   * @param string $lg_code
   * @return array
   */
  public static function GetWords(string $lg_code)
  {
    $lg = MrLanguage::loadBy(mb_strtoupper($lg_code), 'Name');
    if(!$lg)
    {
      return array();
    }

    $out = array();
    foreach (self::GetByLg($lg) as $item)
    {
      $out[$item->getName()] = $item->getTranslate();
    }

    return $out;
  }

  /**
   * Вывод всех русских слов
   *
   * @return array
   */
  public static function GetAllRusWords(): array
  {
    $list = self::GetAll();
    $out = array();
    foreach ($list as $item)
    {
      $out[$item->getName()] = $item->getName();
    }
    return $out;
  }
}