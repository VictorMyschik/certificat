<?php

namespace App\Models\References;

use App\Models\ORM;

class MrTechnicalRegulation extends ORM
{
  public static $className = MrTechnicalRegulation::class;
  protected $table = 'mr_technical_regulation';

  protected $fillable = array(
    'Code',
    'Name',
  );

  public static function getReferenceInfo()
  {
    return array();
  }

  public static function getRouteTable()
  {
    return 'list_technical_regulation_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrTechnicalRegulation
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  //  Цифровой код
  public function getCode(): int
  {
    return $this->Code;
  }

  public function setCode(int $value): void
  {
    $this->Code = $value;
  }

  /**
   * Наименование
   *
   * @return string
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