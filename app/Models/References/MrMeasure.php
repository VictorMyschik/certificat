<?php


namespace App\Models\References;


use App\Models\ORM;

class MrMeasure extends ORM
{
  public static $mr_table = 'mr_measure';
  public static $className = MrMeasure::class;
  protected $table = 'mr_measure';

  protected static $dbFieldsMap = array(
    'Code',
    'TextCode',
    'Name',
  );

  public static function getRouteTable()
  {
    return 'list_measure_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrMeasure
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  //  Цифоровой код
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value)
  {
    $this->Code = $value;
  }

  public function getTextCode(): string
  {
    return $this->TextCode;
  }

  public function setTextCode(string $value)
  {
    $this->TextCode = $value;
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
}