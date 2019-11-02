<?php


namespace App\Http\Models;


class MrDiscount extends ORM
{
  public static $mr_table = 'mr_faq';
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'Name',
    'Kind',
    'DateFrom',
    'DateTo',
    'Description',
    //'CreateDate',
  );

  const KIND_UNKNOWN = 0;


  public static function loadBy($value, $field = 'id'): ?MrDiscount
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  // Наименование скидки
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  // Описание
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }
}