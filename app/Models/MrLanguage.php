<?php

namespace App\Models;

class MrLanguage extends ORM
{
  public static $className = MrLanguage::class;
  protected $table = 'mr_language';
  protected static $dbFieldsMap = array(
    'Name',
    'Description',
  );

  public function before_delete()
  {
    foreach (MrTranslate::GetByLg($this) as $words)
    {
      $words->mr_delete();
    }
  }

  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(string $value): void
  {
    $this->Name = mb_strtoupper($value);
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  ////////////////////////////////////////////////////////////////////////

  /**
   * Текущий язык
   *
   * @return static
   */
  public static function getCurrentLanguage(): self
  {
    return MrLanguage::loadBy(app()->getLocale(), 'Name');
  }

  public static function SelectList()
  {
    $out = array();
    $out[0] = '[не выбрано]';
    foreach (self::all() as $item)
    {
      $out[$item->id()] = $item->getName();
    }

    return $out;
  }
}