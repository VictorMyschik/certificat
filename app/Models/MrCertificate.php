<?php


namespace App\Models;


use App\Helpers\MrDateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificate extends ORM
{
  public static $mr_table = 'mr_certificate';
  public static $className = MrCertificate::class;
  protected $table = 'mr_certificate';

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

  const KIND_UNKNOWN = 0;
  const KIND_CERTIFICATE = 1;
  const KIND_DECLARATION = 2;

  protected static $kinds = array(
    self::KIND_UNKNOWN => '[не выбрано]', //Активен
    self::KIND_CERTIFICATE => 'Сертификат соответствия ТР ЕАЭС', //Активен
    self::KIND_DECLARATION => 'Декларация о соответствии ТР ЕАЭС', // Приостановлен
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
      abort('Неизвестный статус');
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
  public function getDateFrom(): ?MrDateTime
  {
    return $this->DateFrom ? MrDateTime::fromValue($this->DateFrom) : null;
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
  public function getDateTo(): ?MrDateTime
  {
    return $this->DateTo ? MrDateTime::fromValue($this->DateTo) : null;
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

  // Ссылка на оригинал
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
    $out .= MrDateTime::GetFromToDate($this->getDateFrom(), $this->getDateTo());
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
      ->limit(5)
      ->get();

    if(count($list))
    {
      return self::LoadArray($list, self::class);
    }

    return array();
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

  /**
   * недавно искали
   * @param MrUser $user
   * @return mixed
   */
  public static function GetCacheSearch(MrUser $user): array
  {
    return Cache::get('user_search_' . $user->id(), array());
  }

  /**
   * Запись в кэш поиска сертификата
   *
   * @param MrCertificate $certificate
   * @param MrUser $user
   */
  public static function SetCacheSearch(MrCertificate $certificate, MrUser $user)
  {
    $key = 'user_search_' . $user->id();

    $certificates = Cache::get($key, array());
    Cache::forget($key);
    $certificates[$certificate->id()] = $certificate->GetFullName();

    Cache::add($key, $certificates, 3600);
  }
}