<?php

namespace App\Models;

class MrTranslate extends ORM
{
  protected $table = 'mr_translate';
  public static $className = MrTranslate::class;

  protected static $dbFieldsMap = array(
    'Name',
    'LanguageID',
    'Translate',
  );

  /**
   *  На русском
   *
   * @return string|null
   */
  public function getName(): ?string
  {
    return $this->Name;
  }


  public function setName(string $value): void
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
  public function setLanguageID(string $value): void
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

  public function setTranslate(string $value): void
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
    return MrTranslate::LoadArray(['LanguageID' => $lg->id()]);
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
    $list = self::all();
    $out = array();
    foreach ($list as $item)
    {
      $out[$item->getName()] = $item->getName();
    }
    return $out;
  }
}