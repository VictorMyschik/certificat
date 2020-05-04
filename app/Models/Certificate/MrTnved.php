<?php

namespace App\Models\Certificate;

use App\Models\ORM;

class MrTnved extends ORM
{
  public static $mr_table = 'mr_tnved';
  public static $className = MrTnved::class;
  protected $table = 'mr_tnved';

  protected static $dbFieldsMap = array(
    'Code',
    'Name',
  );

  public static function loadBy($value, $field = 'id'): ?MrTnved
  {
    return parent::loadBy((string)$value, $field);
  }

  public function before_save()
  {
    // Если уже существует
    if($object = $this::loadBy($this->getCode()))
    {
      $this->id = $object->id();
    }
  }

  /**
   * Код ТН ВЭД
   *
   * @return string
   */
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value): void
  {
    $this->Code = $value;
  }

  /**
   * Наименование
   *
   * @return string|null
   */
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value): void
  {
    $this->Name = $value;
  }
}