<?php


namespace App\Models;


use App\Helpers\MrDateTime;

class MrCurrency extends ORM
{
  public static $mr_table = 'mr_currencies';
  public static $className = MrCurrency::class;

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

  public function getDateFrom(): ?MrDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom($value)
  {
    $this->setDateNullableField($value, 'DateFrom');
  }

  public function getDateTo(): ?MrDateTime
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

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }


}