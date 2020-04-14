<?php


namespace App\Models;


use App\Helpers\MrDateTime;

class MrTemp extends ORM
{
  public static $mr_table = 'mr_temp';
  public static $className = MrTemp::class;
  protected static $dbFieldsMap = array(
    'RemoteID',
    'RawData',
  );

  public static function loadBy($value, $field = 'id'): ?MrTemp
  {
    return parent::loadBy((string)$value, $field);
  }

  public function getRemoteId(): string
  {
    return $this->RemoteId;
  }

  public function setRemoteId(string $value)
  {
    $this->RemoteId = $value;
  }

  public function getNumber(): string
  {
    return $this->Number;
  }

  public function setNumber(string $value)
  {
    $this->Number = $value;
  }

  public function getDate(): MrDateTime
  {
    return $this->getDateNullableField('Date');
  }

  public function setDate($value)
  {
    return $this->setDateNullableField('Date', $value);
  }

  public function getUpdateDate(): MrDateTime
  {
    return $this->getDateNullableField('UpdateDate');
  }

  public function setUpdateDate($value)
  {
    return $this->setDateNullableField('UpdateDate', $value);
  }

  public function getRawData()
  {
    return $this->RawData;
  }
}