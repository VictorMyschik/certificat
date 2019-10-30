<?php


namespace App\Http\Models;


use App\Models\ORM;

class MrTariff extends ORM
{

  public static $mr_table = 'mr_tariff';
  public static $ident_id = null;
  protected static $dbFieldsMap = array(
    'Name',
    'Measure',
    'Cost',
    'Description',
  );

  public static function loadBy($value, $field = 'id'): ?MrTariff
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return self::$ident_id = parent::mr_save_object($this);
  }

  // Название тарифного плана
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }


  // Название тарифного плана
  public function getMeasure(): int
  {
    return $this->Measure;
  }

  public function setMeasure(string $value)
  {
    $this->Measure = $value;
  }

  // Примечание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }
}