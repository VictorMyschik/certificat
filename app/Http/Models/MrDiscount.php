<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Support\Facades\Cache;

class MrDiscount extends ORM
{
  public static $mr_table = 'mr_discount';
  public static $className = MrDiscount::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'OfficeID',
    'TariffID',
    'DateFrom',
    'DateTo',
    'Amount',
    'Kind'
  );

  const KIND_MONEY = 1;
  const KIND_PERCENT = 2;
  const KIND_DAYS = 3;
  const KIND_DOCUMENTS = 4;

  protected static $kinds = array(
    self::KIND_MONEY => 'в рублях',
    self::KIND_PERCENT => 'в процентах',
    self::KIND_DAYS => 'в днях',
    self::KIND_DOCUMENTS => 'в документах',
  );

  protected static $kinds_code = array(
    self::KIND_MONEY => '$',
    self::KIND_PERCENT => '%',
    self::KIND_DAYS => 'день',
    self::KIND_DOCUMENTS => 'док',
  );

  public static function getKinds()
  {
    return self::$kinds;
  }

  public static function getKindCodes()
  {
    return self::$kinds_code;
  }

  public function getKind(): int
  {
    return $this->Kind;
  }

  public function setKind(int $value)
  {
    if(self::getKinds()[$value])
    {
      $this->Kind = $value;
    }
    else
    {
      dd('Unknown Kind:' . $value);
    }
  }

  public function getKindName()
  {
    return self::getKinds()[$this->getKind()];
  }

  public function getKindCode()
  {
    return self::getKindCodes()[$this->getKind()];
  }

  public static function loadBy($value, $field = 'id'): ?MrDiscount
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    Cache::forget('discount_' . $this->OfficeID);
    return parent::mr_save_object($this);
  }

  protected function before_delete()
  {
    Cache::forget('discount_' . $this->OfficeID);
  }


  public function getOffice(): MrOffice
  {
    return MrOffice::loadBy($this->OfficeID);
  }

  public function setOfficeID(int $value)
  {
    $this->OfficeID = $value;
  }

  public function getTariff(): ?MrTariff
  {
    return MrTariff::loadBy($this->TariffID);
  }

  public function setTariffID(?int $value)
  {
    $this->TariffID = $value;
  }

  public function getDateFrom(): ?MtDateTime
  {
    return MtDateTime::fromValue($this->DateFrom);
  }

  public function setDateFrom($value)
  {
    return $this->DateFrom = MtDateTime::fromValue($value);
  }

  public function getDateTo(): ?MtDateTime
  {
    return MtDateTime::fromValue($this->DateTo);
  }

  public function setDateTo($value)
  {
    $this->DateTo = MtDateTime::fromValue($value);
  }

  public function getAmount(): float
  {
    return (float)$this->Amount;
  }

  public function setAmount(float $value)
  {
    $this->Amount = $value;
  }

////////////////////////////////////////////////////////////////////////////
  public function GetFullName()
  {
    $r = $this->getAmount();
    $r .= ' ';
    $r .= $this->getKindCode();
    return $r;
  }
}