<?php


namespace App\Models\Certificate;


use App\Helpers\MrDateTime;
use App\Models\ORM;
use App\Models\References\MrCountry;
use Carbon\Carbon;

class MrCertificate extends ORM
{
  public static $mr_table = 'mr_certificate';
  public static $className = MrCertificate::class;
  protected $table = 'mr_certificate';

  protected static $dbFieldsMap = array(
    'id',// $table->bigIncrements('id')->autoIncrement();
    'Kind',// $table->integer('Kind');//Тип документа
    'Number',// $table->string('Number');//Регистрационный номер документа
    'DateFrom',// $table->date('DateFrom');//Дата начала срока действия
    'DateTo',// $table->date('DateTo')->nullable();//Дата окончания срока действия
    'CountryID',// $table->integer('CountryID');//Страна
    'Status',// $table->tinyInteger('Status')->default(0);//Статус действия | Действует
    'Auditor',// $table->string('Auditor', 80);//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
    'BlankNumber',// $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
    'DateStatusFrom',// $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DateStatusTo',// $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DocumentBase',// $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
    'WhyChange',// $table->string('WhyChange')->nullable();//Причина изменения статуса
    'SchemaCertificate',// $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
    'Description',// $table->string('Description', 1000)->nullable();//Примечание для себя
    'LinkOut',// $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат

    //'SingleListProductIndicator' признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о соответствии по единой форме: 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
    ///'WriteDate' // $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи
  );

  const KIND_UNKNOWN = 0;
  const KIND_CERTIFICATE = 1;
  const KIND_DECLARATION = 2;

  protected static $kinds = array(
    self::KIND_UNKNOWN     => '[не выбрано]', //Активен
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
    self::STATUS_ACTIVE   => 'активен', //Активен
    self::STATUS_STOPPED  => 'приостановлен', // Приостановлен
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
  public function getWriteDate(): ?MrDateTime
  {
    return $this->getDateNullableField($this->WriteDate);
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

  // Статус действия
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
      abort('Неизвестный статус');
    }
  }

  /**
   * ФИО аудитора
   *
   * @return string
   */
  public function getAuditor(): string
  {
    return $this->Auditor;
  }

  public function setAuditor(string $value)
  {
    $this->Auditor = $value;
  }

  //Номер бланка | BY 0008456
  public function getBlankNumber(): ?string
  {
    return $this->BlankNumber;
  }

  public function setBlankNumber(?string $value)
  {
    $this->BlankNumber = $value;
  }

  /**
   * Признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с
   * выдачей сертификатов соответствия и деклараций о соответствии по единой форме:
   * 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
   * */
  public function getSingleListProductIndicator(): bool
  {
    return (bool)$this->SingleListProductIndicator;
  }

  public function setSingleListProductIndicator(bool $value)
  {
    $this->SingleListProductIndicator = $value;
  }

  // Срок действия статуса | c 02.04.2020 по 01.04.2025
  public function getDateStatusFrom(): ?MrDateTime
  {
    return $this->getDateNullableField('DateStatusFrom');
  }

  public function setDateStatusFrom($value)
  {
    $this->setDateNullableField($value, 'DateStatusFrom');
  }

  public function getDateStatusTo(): ?MrDateTime
  {
    return $this->getDateNullableField('DateStatusTo');
  }

  public function setDateStatusTo($value)
  {
    $this->setDateNullableField($value, 'DateStatusTo');
  }

  // Документ, на основании которого установлен статус
  public function getDocumentBase(): ?string
  {
    return $this->DocumentBase;
  }

  public function setDocumentBase(?string $value)
  {
    return $this->DocumentBase = $value;
  }

  // Причина изменения статуса
  public function getWhyChange(): ?string
  {
    return $this->WhyChange;
  }

  public function setWhyChange(?string $value)
  {
    return $this->WhyChange = $value;
  }

  // Схема сертификации (декларирования) | 1с
  public function getSchemaCertificate(): ?string
  {
    return $this->SchemaCertificate;
  }

  public function setSchemaCertificate(?string $value)
  {
    return $this->SchemaCertificate = $value;
  }

  // Дополнительные сведения
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    return $this->Description = $value;
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
}