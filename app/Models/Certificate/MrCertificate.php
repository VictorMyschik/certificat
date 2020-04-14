<?php


namespace App\Models\Certificate;


use App\Helpers\MrDateTime;
use App\Models\ORM;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use Carbon\Carbon;

class MrCertificate extends ORM
{
  public static $mr_table = 'mr_certificate';
  public static $className = MrCertificate::class;
  protected $table = 'mr_certificate';

  protected static $dbFieldsMap = array(
    'id',// $table->bigIncrements('id')->autoIncrement();
    'CertificateKindID',// $table->integer('Kind');//Тип документа
    'Number',// $table->string('Number');//Регистрационный номер документа
    'DateFrom',// $table->date('DateFrom');//Дата начала срока действия
    'DateTo',// $table->date('DateTo')->nullable();//Дата окончания срока действия
    'CountryID',// $table->integer('CountryID');//Страна
    'Status',// $table->tinyInteger('Status')->default(0);//Статус действия | Действует
    'AuditorID',// $table->string('Auditor', 80);//Эксперт - аудитор (ФИО) | Игорь Владимирович Гурин
    'BlankNumber',// $table->string('BlankNumber', 50)->nullable();//Номер бланка | BY 0008456
    'DateStatusFrom',// $table->date('DateStatusFrom')->nullable();//Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DateStatusTo',// $table->date('DateStatusTo')->nullable();  //Срок действия статуса | c 02.04.2020 по 01.04.2025
    'DocumentBase',// $table->string('DocumentBase')->nullable();//Документ, на основании которого установлен статус
    'WhyChange',// $table->string('WhyChange')->nullable();//Причина изменения статуса
    'SchemaCertificate',// $table->string('SchemaCertificate', 3)->nullable();//Схема сертификации (декларирования) | 1с
    'Description',// $table->string('Description', 1000)->nullable();//Примечание для себя
    'LinkOut',// $table->string('LinkOut')->nullable();//Ссылка на оригинальный сертификат
    'DateUpdateEAES',// Дата обновления на ЕАЭС
    'SingleListProductIndicator', //признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о соответствии по единой форме: 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
    ///'WriteDate' // $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи
  );

  const STATUS_ACTIVE = 1;
  const STATUS_PAUSED = 2;
  const STATUS_STOPPED = 3;
  CONST STATUS_CONTINUED = 4;
  CONST STATUS_REOPENED = 5;
  CONST STATUS_ARHIVED = 6;

  protected static $statuses = array(
    self::STATUS_ACTIVE    => 'действует',
    self::STATUS_PAUSED    => 'приостановлен',
    self::STATUS_STOPPED   => 'прекращен',
    self::STATUS_CONTINUED => 'продлен',
    self::STATUS_REOPENED  => 'возобновлен',
    self::STATUS_ARHIVED   => 'архивный',
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

  /**
   * Тип документа
   *
   * @return MrCertificateKind
   */
  public function getCertificateKind(): MrCertificateKind
  {
    return MrCertificateKind::loadBy($this->CertificateKindID);
  }

  public function setCertificateKindID(int $value)
  {
    $this->CertificateKindID = $value;
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
    $this->setDateNullableField($value, 'DateFrom');
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
    //if(isset(self::$statuses[$value]))
    //{
      $this->Status = $value;
    //}
    //else
    //{
    //  dd('Неизвестный статус');
    //}
  }

  /**
   * ФИО аудитора
   *
   * @return MrFio|null
   */
  public function getAuditor(): ?MrFio
  {
    return MrFio::loadBy('AuditorID');
  }

  public function setAuditorID(?int $value)
  {
    $this->AuditorID = $value;
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

  public function getDateUpdateEAES(): ?MrDateTime
  {
    return $this->getDateNullableField('DateUpdateEAES');
  }

  public function setDateUpdateEAES($value)
  {
    return $this->setDateNullableField($value, 'DateUpdateEAES');
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