<?php


namespace App\Models;


class MrLanguage extends ORM
{
  public static $mr_table = 'mr_language';
  public static $className = MrLanguage::class;

  protected static $dbFieldsMap = array(
    'Name',
    'Description',
  );

  public static function loadBy($value, $field = 'id'): ?MrLanguage
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

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

  public function setName(string $value)
  {
    $this->Name = mb_strtoupper($value);
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  ////////////////////////////////////////////////////////////////////////
  public static function SelectList()
  {
    $out = array();
    $out[0] = '[не выбрано]';
    foreach (self::GetAll() as $item)
    {
      $out[$item->id()] = $item->getName();
    }

    return $out;
  }
}