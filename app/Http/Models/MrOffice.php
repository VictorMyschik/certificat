<?php


namespace App\Http\Models;


use App\Models\ORM;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrOffice extends ORM
{
  public static $mr_table = 'mr_office';
  public static $className = MrOffice::class;
  protected static $dbFieldsMap = array(
    'Name',
    'Description',
    //'CreateDate'
  );

  public static function loadBy($value, $field = 'id'): ?MrOffice
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public function canDelete(): bool
  {
    return true;
  }

  public function before_delete()
  {
    foreach ($this->GetTariffs() as $tariffInOffice)
    {
      $tariffInOffice->mr_delete();
    }

    foreach ($this->GetUsers() as $userInOffice)
    {
      $userInOffice->mr_delete();
    }
  }

  /**
   * @return MrTariffInOffice[]
   */
  public function GetTariffs(): array
  {
    $list = DB::table(MrTariffInOffice::$mr_table)->where('OfficeID', $this->id())->get();
    return parent::LoadArray($list, MrTariffInOffice::class);
  }


  /**
   * @return MrTariffInOffice[]
   */
  public function GetUsers(): array
  {
    $list = DB::table(MrUserInOffice::$mr_table)->where('OfficeID', $this->id())->get();
    return parent::LoadArray($list, MrUserInOffice::class);
  }


  // Описание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  // Наименование офиса
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  // Дата создания офиса
  public function getCreateDate(): Carbon
  {
    return new Carbon($this->CreateDate);
  }

  //////////////////////////////////////////////////////////////////

}