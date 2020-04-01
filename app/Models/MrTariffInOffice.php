<?php


namespace App\Models;


use App\Helpers\MrDateTime;
use Illuminate\Support\Facades\DB;

class MrTariffInOffice extends ORM
{
  public static $mr_table = 'mr_tariff_in_office';
  public static $className = MrTariffInOffice::class;

  protected static $dbFieldsMap = array(
    'OfficeID',
    'TariffID',
    //'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrTariffInOffice
  {
    return parent::loadBy((string)$value, $field);
  }

  public function before_delete()
  {
    foreach ($this->getOffice()->GetDiscount() as $discount)
    {
      if($discount->getTariff()->id() == $this->getTariff()->id())
      {
        $discount->mr_delete();
      }
    }
  }

  public function canEdit()
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  public function getOffice(): MrOffice
  {
    return MrOffice::loadBy($this->OfficeID);
  }

  public function setOfficeID(int $value)
  {
    $this->OfficeID = $value;
  }

  public function getTariff(): MrTariff
  {
    return MrTariff::loadBy($this->TariffID);
  }

  public function setTariffID(int $value)
  {
    $this->TariffID = $value;
  }

  public function getWriteDate(): MrDateTime
  {
    return parent::getDateNullableField('WriteDate');
  }

  /////////////////////////////////////////////////////////////////
  public function GetDiscountList()
  {
    $list = DB::table(MrDiscount::$mr_table)
      ->where('OfficeID', '=', $this->getOffice()->id())
      ->where('TariffID', '=', $this->getTariff()->id())
      ->get();

    return parent::LoadArray($list, MrDiscount::class);
  }
}