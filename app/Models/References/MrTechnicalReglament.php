<?php

namespace App\Models\References;

use App\Models\ORM;

/**
 * Принятые технические регламенты
 */
class MrTechnicalReglament extends ORM
{
  public static $className = MrTechnicalReglament::class;
  protected $table = 'mr_technical_reglament';

  protected $fillable = array(
    'Code',
    'Name',
    'Link',
  );

  public static function getReferenceInfo()
  {
    return array();
  }

  public static function getRouteTable()
  {
    return 'list_technical_reglament_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrTechnicalReglament
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  //  Цифровой код
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value): void
  {
    $this->Code = $value;
  }

  public function getLink(): string
  {
    return $this->Link;
  }

  public function setLink(string $value): void
  {
    $this->Link = $value;
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

  public function setName(string $value): void
  {
    $this->Name = $value;
  }
}