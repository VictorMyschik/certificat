<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;

class MrCurrency extends ORM
{
  public static $mr_table = 'mr_currency';
  public static $className = MrCurrency::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'Code',
    'TextCode',
    'DateFrom',
    'DateTo',
    'Name',
    'Rounding',
    'Description'
  );

  public static function loadBy($value, $field = 'id'): ?MrCurrency
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
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

  public function getDateFrom(): ?MtDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom($value)
  {
    $this->setDateNullableField($value, 'DateFrom');
  }

  public function getDateTo(): ?MtDateTime
  {
    return $this->getDateNullableField('DateTo');
  }

  public function setDateTo($value)
  {
    $this->setDateNullableField($value, 'DateTo');
  }

  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  public function getRounding(): ?int
  {
    return $this->Rounding;
  }

  public function setRounding(int $value)
  {
    $this->Rounding = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(string $value)
  {
    $this->Description = $value;
  }


}