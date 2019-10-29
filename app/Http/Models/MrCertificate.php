<?php


namespace App\Http\Models;


use App\Models\ORM;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificate extends ORM
{
  public static $mr_table = 'mr_certificate';
  public static $className = MrCertificate::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'Kind',
    'Number',
    'DateFrom',
    'DateTo',
    'CountryID',
    'Status',
    'LinkOut',
    'Description',
    // 'WriteDate',
  );

  const KIND_CERTIFICATE = 1;
  const KIND_DECLARATION = 2;

  protected static $kinds = array(
    self::KIND_CERTIFICATE => 'сертификат соответствия', //Активен
    self::KIND_DECLARATION => 'декларация о соответствии', // Приостановлен
  );

  public static function getKinds()
  {
    return self::$kinds;
  }

  const STATUS_ACTIVE = 1;
  const STATUS_STOPPED = 2;
  const STATUS_RECALLED = 3;

  protected static $statuses = array(
    self::STATUS_ACTIVE => 'активен', //Активен
    self::STATUS_STOPPED => 'приостановлен', // Приостановлен
    self::STATUS_RECALLED => 'отозван', // Отозван
  );

  public static function getStatuses()
  {
    return self::$statuses;
  }

  public static function loadBy($value, $field = 'id'): ?MrCertificate
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {
    foreach ($this->GetDetails() as $details)
    {
      $details->mr_delete();
    }
  }

  public function save_mr()
  {
    Cache::forget('certificate' . $this->id());
    return parent::mr_save_object($this);
  }

  public function getKind(): ?int
  {
    return $this->Kind;
  }

  public function getKindName(): string
  {
    return self::getKinds()[$this->Kind];
  }

  public function setKind(int $value)
  {
    if(self::$kinds[$value])
    {
      $this->Kind = $value;
    }
    else
    {
      dd('Неизвестный статус');
    }
  }

  // Номер
  public function getNumber(): ?string
  {
    return $this->Number;
  }

  public function setNumber(string $value)
  {
    $this->Number = $value;
  }

  // Дата начала блокировки
  public function getDateFrom(): ?Carbon
  {
    return $this->DateFrom ? new Carbon($this->DateFrom) : null;
  }

  public function setDateFrom($value)
  {
    if(is_string($value))
    {
      $value = new Carbon($value);
    }

    $this->DateFrom = $value;
  }

  // Дата окончания
  public function getDateTo(): ?Carbon
  {
    return $this->DateTo ? new Carbon($this->DateTo) : null;
  }

  public function setDateTo($value)
  {
    if(is_string($value))
    {
      $value = new Carbon($value);
    }

    $this->DateTo = $value;
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

  // Описание
  public function getLinkOut(): ?string
  {
    return $this->LinkOut;
  }

  public function setLinkOut(?string $value)
  {
    $this->LinkOut = $value;
  }

  // Дата создания/обновления записи
  public function getWriteDate(): Carbon
  {
    return new Carbon($this->WriteDate);
  }

  // Страна
  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(int $value)
  {
    $this->CountryID = $value;
  }

  // Статус
  public function getStatus(): ?int
  {
    return $this->Status;
  }

  public function getStatusName(): string
  {
    return self::$statuses[$this->Status];
  }

  public function setStatus(int $value)
  {
    if(self::$statuses[$value])
    {
      $this->Status = $value;
    }
    else
    {
      dd('Неизвестный статус');
    }
  }

  //////////////////////////////////////////////////////////////////////////
  public function GetFullName(): string
  {
    $out = $this->getNumber();
    $out .= ' с ';
    $out .= $this->getDateFrom()->format('d.m.Y');
    $out .= ' по ';
    $out .= $this->getDateTo()->format('d.m.Y');
    $out .= ' (';
    $out .= $this->getStatusName();
    $out .= ')';

    return $out;
  }

  /**
   * поиск по серитфикатам
   *
   * @param string|null $str
   * @return array|object[]
   */
  public static function Search(?string $str)
  {
    if(!$str)
    {
      return array();
    }

    $list = DB::table(MrCertificate::$mr_table)
      ->where('Number', 'LIKE', '%' . $str . '%')
      ->limit(1)
      ->get();

    return self::LoadArray($list, self::class);
  }

  /**
   * Массив сведений о сертификате
   *
   * @return MrCertificateDetails[]
   */
  public function GetDetails(): array
  {
    //Cache::forget('certificate' . $this->id());
    $r = Cache::rememberForever('certificate' . $this->id(), function () {
      return DB::table(MrCertificateDetails::$mr_table)->WHERE('CertificateID', '=', $this->id())->get();
    });

    return parent::LoadArray($r, MrCertificateDetails::class);
  }

}