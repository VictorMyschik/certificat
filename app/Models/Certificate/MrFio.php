<?php


namespace App\Models\Certificate;


use App\Models\Lego\MrCommunicateTrait;
use App\Models\MrUser;
use App\Models\ORM;
use Illuminate\Support\Facades\DB;

class MrFio extends ORM
{
  use MrCommunicateTrait;

  public static $mr_table = 'mr_fio';
  public static $className = MrFio::class;
  protected $table = 'mr_fio';

  protected static $dbFieldsMap = array(
    'FirstName',//Имя max 120
    'MiddleName',//Отчество max 120
    'LastName', //Фамилия max 120
    'PositionName' //Должность max 120
  );

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  public static function loadBy($value, $field = 'id'): ?MrFio
  {
    return parent::loadBy((string)$value, $field);
  }

  public function before_save()
  {
    $data = DB::table(self::$mr_table)
      ->where('FirstName', $this->getFirstName())
      ->where('MiddleName', $this->getMiddleName())
      ->where('LastName', $this->getLastName())
      ->where('PositionName', $this->getPositionName())
      ->first(['id']);

    if($data)
    {
      $this->id = $data->id;
    }
    else
    {
      $this->id = 0;
    }
  }

  /**
   * Имя
   *
   * @return string|null
   */
  public function getFirstName(): ?string
  {
    return $this->FirstName;
  }

  public function setFirstName(?string $value)
  {
    $this->FirstName = $value;
  }

  /**
   * Отчество
   *
   * @return string|null
   */
  public function getMiddleName(): ?string
  {
    return $this->MiddleName;
  }

  public function setMiddleName(?string $value)
  {
    $this->MiddleName = $value;
  }

  /**
   * Фамилия
   *
   * @return string|null
   */
  public function getLastName(): ?string
  {
    return $this->LastName;
  }

  public function setLastName(?string $value)
  {
    $this->LastName = $value;
  }

  /**
   * Должность
   *
   * @return string|null
   */
  public function getPositionName(): ?string
  {
    return $this->PositionName;
  }

  public function setPositionName(?string $value)
  {
    $this->PositionName = $value;
  }

  public function GetFullName(): string
  {
    $r = '';

    $r .= $this->getFirstName();
    $r .= strlen($r) ? ' ' : '';
    $r .= $this->getMiddleName();
    $r .= strlen($r) ? ' ' : '';
    $r .= $this->getLastName();

    return $r;
  }

  public function GetFullNameWithPosition(): string
  {
    $r = $this->GetFullName();

    if($this->getPositionName())
    {
      $r .= ' (' . $this->getPositionName() . ')';
    }

    return $r;
  }

}