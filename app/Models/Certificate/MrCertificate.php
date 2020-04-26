<?php


namespace App\Models\Certificate;


use App\Classes\Xml\MrXmlImportBase;
use App\Helpers\MrCacheHelper;
use App\Helpers\MrDateTime;
use App\Models\Lego\MrCertificateDocument;
use App\Models\ORM;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
    'AuthorityID',//Сведения об органе по оценке соответствия
    'DateUpdateEAES',// Дата обновления на ЕАЭС
    'SingleListProductIndicator', //признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о соответствии по единой форме: 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
    ///'WriteDate' // $table->timestamp('WriteDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Момент записи

    'ManufacturerID' // Производитель
  );

  const STATUS_ACTIVE = 1;
  const STATUS_PAUSED = 2;
  const STATUS_STOPPED = 3;
  const STATUS_CONTINUED = 4;
  const STATUS_REOPENED = 5;
  const STATUS_ARHIVED = 6;

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

  public function flush()
  {
    parent::flush();
    Cache::forget('documents' . '_' . $this->id() . '_list');
  }

  public static $hashed = array();

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
    return $this->getDateNullableField('WriteDate');
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
    return MrFio::loadBy($this->AuditorID);
  }

  public function setAuditorID(?int $value)
  {
    $this->AuditorID = $value;
  }

  /**
   * Орган сертификации
   *
   * @return MrConformityAuthority|null
   */
  public function getAuthority(): ?MrConformityAuthority
  {
    return MrConformityAuthority::loadBy($this->AuthorityID);
  }

  public function setAuthorityID(?int $value)
  {
    $this->AuthorityID = $value;
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

  // Производитель
  public function getManufacturer(): ?MrManufacturer
  {
    return MrManufacturer::loadBy($this->ManufacturerID);
  }

  public function setManufacturerID(?int $value)
  {
    return $this->ManufacturerID = $value;
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

  public static function GetHashedList()
  {
    if(count(self::$hashed))
    {
      return self::$hashed;
    }

    $list = DB::table(self::$mr_table)->pluck('Number')->toArray();
    foreach ($list as $item)
    {
      self::$hashed[$item] = $item;
    }

    return self::$hashed;
  }

  /**
   * Оновление сертификата
   */
  public function CertificateUpdate(): array
  {
    $url = $this->getLinkOut();

    $xml = self::GetCertificateFromURL($url);
    return MrXmlImportBase::ParseXmlFromString($xml);
  }

  /**
   * Получение данных из интернета
   *
   * @param string $url
   * @return string|null
   */
  public static function GetCertificateFromURL(string $url): ?string
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
  }

  /**
   * Получение hash-ID из ссылки на сайте ЕАЭС
   *
   * @return string
   */
  public function getHash(): string
  {
    return substr($this->getLinkOut(), strlen($this->getLinkOut()) - 26, 24);
  }

  /**
   * Срок действия статуса
   *
   * @return string
   */
  public function GetStatusPeriod(): string
  {
    return MrDateTime::GetFromToDate($this->getDateStatusFrom(), $this->getDateStatusTo());
  }

  /**
   * Документ, на основании которого установлен статус
   *
   * @return string|null
   */
  public function GetChangeStatusString(): ?string
  {
    return $this->getDocumentBase();
  }

  /**
   * Список документов сертификата
   *
   * @return MrCertificateDocument[]
   */
  public function GetDocuments(): array
  {
    return MrCacheHelper::GetCachedObjectList('documents' . '_' . $this->id() . '_list', MrCertificateDocument::class, function () {
      return DB::table(MrCertificateDocument::$mr_table)->where('CertificateID', $this->id())->pluck('id')->toArray();
    });
  }

  /**
   * Создание массив для использования во Vue
   */
  public function GetJsonData(): array
  {
    $out = array();

    $out['certificate'] = array(
      'DateFrom'          => $this->getDateFrom() ? $this->getDateFrom()->getShortDate() : null,
      'DateTo'            => $this->getDateTo() ? $this->getDateTo()->getShortDate() : null,
      'Auditor'           => $this->getAuditor() ? $this->getAuditor()->GetFullName() : null,
      'BlankNumber'       => $this->getBlankNumber(),
      'StatusDates'       => MrDateTime::GetFromToDate($this->getDateStatusFrom(), $this->getDateStatusTo()),
      'BaseDocument'      => $this->getDocumentBase(),
      'WhyChange'         => $this->getWhyChange(),
      'SchemaCertificate' => $this->getSchemaCertificate(),
      'Description'       => $this->getDescription(),
    );

    //// Орган по сертификации
    $out['authority'] = array();

    if($authority = $this->getAuthority())
    {
      $out['authority']['Name'] = $authority->getName();

      if($officer = $authority->getOfficerDetails())
      {
        $officer_out = $officer->GetFullName();
        $officer_out .= $officer->getPositionName() ? ' (' . $officer->getPositionName() . ')' : null;
      }
      else
      {
        $officer_out = '';
      }

      $out['authority']['FIO'] = $officer_out;

      $out['authority']['Address1'] = $authority->getAddress1() ? $authority->getAddress1()->GetFullAddress() : null;
      $out['authority']['Address2'] = $authority->getAddress2() ? $authority->getAddress2()->GetFullAddress() : null;
      $out['authority']['DocumentNumber'] = $authority->getDocumentNumber();
      $out['authority']['DocumentDate'] = $authority->getDocumentDate() ? $authority->getDocumentDate()->getShortDate() : null;
      $out['authority']['communicate'] = $officer ? $officer->GetCommunicateOut() : array();
    }

    //// Производитель
    $out['manufacturer'] = array();
    if($manufacturer = $this->getManufacturer())
    {
      $out['manufacturer']['Name'] = $manufacturer->getName();
      if($country = $manufacturer->getCountry())
      {
        $out['manufacturer']['Country'] = $country->getName();
        $name_fl = mb_strtolower($country->getISO3166alpha2());
        $flag_img_html = "https://img.geonames.org/flags/m/{$name_fl}.png";
      }

      $out['manufacturer']['CountryFlag'] = $flag_img_html ?? null;
      $out['manufacturer']['Address1'] = $manufacturer->getAddress1() ? $manufacturer->getAddress1()->GetFullAddress() : null;
      $out['manufacturer']['Address2'] = $manufacturer->getAddress2() ? $manufacturer->getAddress2()->GetFullAddress() : null;
    }

    //// Документы
    $documents = $this->GetDocuments();

    foreach ($documents as $dil)
    {
      $document = $dil->getDocument();
      $out['documents'][$document->getKind()][] = array(
        'KindName'      => $document->getKindName(),
        'Name'          => $document->getName(),
        'Number'        => $document->getNumber(),
        'Date'          => $document->getDate() ? $document->getDate()->getShortDate() : null,
        'DateFrom'      => $document->getDateFrom() ? $document->getDateFrom()->getShortDate() : null,
        'DateTo'        => $document->getDateTo() ? $document->getDateTo()->getShortDate() : null,
        'Organisation'  => $document->getOrganisation(),
        'Accreditation' => $document->getAccreditation(),
        'Description'   => $document->getDescription(),
        'IsIncludeIn'   => $document->isInclude(),
        'id'            => $document->id(),
      );
    }

    return $out;
  }
}