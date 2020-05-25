<?php

namespace App\Models\Certificate;

use App\Classes\Xml\MrXmlImportBase;
use App\Helpers\MrCacheHelper;
use App\Helpers\MrDateTime;
use App\Models\Lego\MrCertificateDocument;
use App\Models\ORM;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use App\Models\References\MrTechnicalRegulation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificate extends ORM
{
  public static $className = MrCertificate::class;
  protected $table = 'mr_certificate';

  protected $fillable = array(
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

      'ManufacturerID', // Производитель
      'ApplicantID',
      'TechnicalRegulationKindID'// Кодовое обозначение вида объекта технического регулирования
  );

  const STATUS_ACTIVE = 1;
  const STATUS_PAUSED = 2;
  const STATUS_STOPPED = 3;
  const STATUS_CONTINUED = 4;
  const STATUS_REOPENED = 5;
  const STATUS_ARCHIVED = 6;

  protected static $statuses = array(
      self::STATUS_ACTIVE    => 'действует',
      self::STATUS_PAUSED    => 'приостановлен',
      self::STATUS_STOPPED   => 'прекращен',
      self::STATUS_CONTINUED => 'продлен',
      self::STATUS_REOPENED  => 'возобновлен',
      self::STATUS_ARCHIVED  => 'архивный',
  );


  public static function getStatuses()
  {
    return self::$statuses;
  }

  /*public static function loadBy($value, $field = 'id'): ?MrCertificate
  {
    return parent::loadBy((string)$value, $field);
  }*/

  protected function before_delete()
  {

  }

  public function flush()
  {
    parent::flush();

    // Список документов сертификата
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

  public function setCertificateKindID(int $value): void
  {
    $this->CertificateKindID = $value;
  }

  // Номер
  public function getNumber(): string
  {
    return $this->Number;
  }

  public function setNumber(string $value): void
  {
    $this->Number = $value;
  }

  // Дата начала блокировки
  public function getDateFrom(): ?MrDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom($value)
  {
    $this->setDateNullableField($value, 'DateFrom');
  }

  // Дата окончания
  public function getDateTo(): ?MrDateTime
  {
    return $this->getDateNullableField('DateTo');
  }

  public function setDateTo($value): void
  {
    $this->setDateNullableField($value, 'DateTo');
  }

  // Ссылка на оригинал
  public function getLinkOut(): ?string
  {
    return $this->LinkOut;
  }

  public function setLinkOut(?string $value): void
  {
    $this->LinkOut = $value;
  }

  // Дата создания/обновления записи
  public function getWriteDate(): ?MrDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }

  // Страна
  public function getCountry(): MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(int $value): void
  {
    $this->CountryID = $value;
  }

  // Кодовое обозначение вида объекта технического регулирования
  public function getTechnicalRegulationKind(): ?MrTechnicalRegulation
  {
    return MrTechnicalRegulation::loadBy($this->TechnicalRegulationKindID);
  }

  public function setTechnicalRegulationKindID(?int $value): void
  {
    $this->TechnicalRegulationKindID = $value;
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

  public function setStatus(int $value): void
  {
    if (self::$statuses[$value] ?? null)
    {
      $this->Status = $value;
    }
    else
    {
      dd('Неизвестный статус действия сертификата: ' . $value);
    }
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

  public function setAuditorID(?int $value): void
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

  public function setAuthorityID(?int $value): void
  {
    $this->AuthorityID = $value;
  }

  //Номер бланка | BY 0008456
  public function getBlankNumber(): ?string
  {
    return $this->BlankNumber;
  }

  public function setBlankNumber(?string $value): void
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

  public function setDateStatusFrom($value): void
  {
    $this->setDateNullableField($value, 'DateStatusFrom');
  }

  public function getDateStatusTo(): ?MrDateTime
  {
    return $this->getDateNullableField('DateStatusTo');
  }

  public function setDateStatusTo($value): void
  {
    $this->setDateNullableField($value, 'DateStatusTo');
  }

  // Документ, на основании которого установлен статус
  public function getDocumentBase(): ?string
  {
    return $this->DocumentBase;
  }

  public function setDocumentBase(?string $value): void
  {
    $this->DocumentBase = $value;
  }

  // Причина изменения статуса
  public function getWhyChange(): ?string
  {
    return $this->WhyChange;
  }

  public function setWhyChange(?string $value): void
  {
    $this->WhyChange = $value;
  }

  // Схема сертификации (декларирования) | 1с
  public function getSchemaCertificate(): ?string
  {
    return $this->SchemaCertificate;
  }

  public function setSchemaCertificate(?string $value): void
  {
    $this->SchemaCertificate = $value;
  }

  // Дополнительные сведения
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  // Производитель
  public function getManufacturer(): ?MrManufacturer
  {
    return MrManufacturer::loadBy($this->ManufacturerID);
  }

  public function setManufacturerID(?int $value): void
  {
    $this->ManufacturerID = $value;
  }

  // Заявитель
  public function getApplicant(): ?MrApplicant
  {
    return MrApplicant::loadBy($this->ApplicantID);
  }

  public function setApplicantID(?int $value): void
  {
    $this->ApplicantID = $value;
  }

  public function getDateUpdateEAES(): ?MrDateTime
  {
    return $this->getDateNullableField('DateUpdateEAES');
  }

  public function setDateUpdateEAES($value): void
  {
    $this->setDateNullableField($value, 'DateUpdateEAES');
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
   * Список номеров сертификатов
   *
   * @return array
   */
  public static function GetHashedList()
  {
    if (count(self::$hashed))
    {
      return self::$hashed;
    }

    $list = DB::table(self::getTableName())->pluck('Number')->toArray();
    foreach ($list as $item)
    {
      self::$hashed[$item] = $item;
    }

    return self::$hashed;
  }

  /**
   * Обновление сертификата
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
      return DB::table(MrCertificateDocument::getTableName())->where('CertificateID', $this->id())->pluck('id')->toArray();
    });
  }

  /**
   * Создание массив для использования во Vue
   */
  public function GetJsonData(): array
  {
    $out = array();

    $out['certificate'] = array(
        'Country'                  => __('mr-t.' . $this->getCountry()->getName()),
        'StatusName'               => $this->getStatusName(),
        'Status'                   => $this->getStatus(),
        'CertificateKindName'      => $this->getCertificateKind()->getName(),
        'CertificateKindShortName' => $this->getCertificateKind()->getShortName(),
        'CountryAlpha2'            => mb_strtolower($this->getCountry()->getISO3166alpha2()),
        'Number'                   => $this->getNumber(),
        'DateFrom'                 => $this->getDateFrom() ? $this->getDateFrom()->getShortDate() : null,
        'DateTo'                   => $this->getDateTo() ? $this->getDateTo()->getShortDate() : null,
        'Auditor'                  => $this->getAuditor() ? $this->getAuditor()->GetFullName() : null,
        'BlankNumber'              => $this->getBlankNumber(),
        'StatusDates'              => MrDateTime::GetFromToDate($this->getDateStatusFrom(), $this->getDateStatusTo()),
        'BaseDocument'             => $this->getDocumentBase(),
        'WhyChange'                => $this->getWhyChange(),
        'SchemaCertificate'        => $this->getSchemaCertificate(),
        'Description'              => $this->getDescription(),
    );

    //// Орган по сертификации
    $out['authority'] = array();

    if ($authority = $this->getAuthority())
    {
      $out['authority']['Name'] = $authority->getName();

      $out['authority']['FIO'] = $authority->getOfficerDetails() ? $authority->getOfficerDetails()->GetFullNameWithPosition() : '';

      $out['authority']['Address1'] = $authority->getAddress1() ? $authority->getAddress1()->GetFullAddress() : null;
      $out['authority']['Address2'] = $authority->getAddress2() ? $authority->getAddress2()->GetFullAddress() : null;
      $out['authority']['DocumentNumber'] = $authority->getDocumentNumber();
      $out['authority']['DocumentDate'] = $authority->getDocumentDate() ? $authority->getDocumentDate()->getShortDate() : null;
      $out['authority']['Communicate'] = $authority->getOfficerDetails() ? $authority->getOfficerDetails()->GetCommunicateOut() : array();
    }

    //// Производитель
    $out['manufacturer'] = array();
    if ($manufacturer = $this->getManufacturer())
    {
      $out['manufacturer']['Name'] = $manufacturer->getName();
      $out['manufacturer']['Country'] = $manufacturer->getCountry() ? $manufacturer->getCountry()->getName() : '';
      $out['manufacturer']['Address1'] = $manufacturer->getAddress1() ? $manufacturer->getAddress1()->GetFullAddress() : null;
      $out['manufacturer']['Address2'] = $manufacturer->getAddress2() ? $manufacturer->getAddress2()->GetFullAddress() : null;

      //// Товары
      foreach ($manufacturer->GetProducts() as $key => $product)
      {
        $out['manufacturer']['products'][$key] = array(
            'Name'        => $product->getName(),
            'Description' => $product->getDescription(),
        );

        foreach ($product->GetProductInfo() as $info)
        {
          $out['manufacturer']['products'][$key]['Info'][] = array(
              'Name'             => $info->getName(),
              'TnvedCode'        => $info->GetTnvedExt() ? $info->GetTnvedExt()->getCode() : null,
              'ManufacturedDate' => $info->getManufacturedDate() ? $info->getManufacturedDate()->getShortDate() : null,
              'ExpiryDate'       => $info->getExpiryDate() ? $info->getExpiryDate()->getShortDate() : null,
              'InstanceId'       => $info->getInstanceId(),
              'Description'      => $info->getDescription(),
              'Measure'          => $info->getMeasure() ? $info->getMeasure()->getName() : null,
          );
        }
      }

    }

    //// Документы
    $documents = $this->GetDocuments();
    $out['documents'] = array();
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
      );
    }

    //// Заявитель
    $out['applicant'] = array();
    if ($applicant = $this->getApplicant())
    {
      $out['applicant'] = array(
          'Name'        => $applicant->getName(),
          'BusinessId'  => $applicant->getBusinessEntityId(),
          'Country'     => $applicant->getCountry() ? $applicant->getCountry()->getName() : null,
          'Address1'    => $applicant->getAddress1() ? $applicant->getAddress1()->GetFullAddress() : null,
          'Address2'    => $applicant->getAddress2() ? $applicant->getAddress2()->GetFullAddress() : null,
          'Fio'         => $applicant->getFio() ? $applicant->getFio()->GetFullNameWithPosition() : '',
          'Communicate' => $applicant->GetCommunicateOut(),
      );
    }

    return $out;
  }

  /**
   * Поиск сертификата
   *
   * @param string|null $text
   * @return array
   */
  public static function Search(?string $text): array
  {
    if (!$text)
    {
      return array();
    }

    $list = DB::table(self::getTableName())
        ->join('mr_manufacturer', 'mr_manufacturer.id', '=', self::getTableName() . '.id')
        ->join('mr_product', 'mr_product.ManufacturerID', '=', 'mr_manufacturer.id')
        ->join('mr_product_info', 'mr_product_info.ProductID', '=', 'mr_product.id')
        ->Where('mr_certificate.Number', 'LIKE', '%' . $text . '%')
        ->orWhere('mr_manufacturer.Name', 'LIKE', '%' . $text . '%')
        ->orWhere('mr_product.Name', 'LIKE', '%' . $text . '%')
        ->orWhere('mr_product.Description', 'LIKE', '%' . $text . '%')
        ->orWhere('mr_product_info.InstanceId', 'LIKE', '%' . $text . '%')
        ->limit(15)->get(['mr_certificate.id', 'mr_certificate.Number', 'mr_certificate.Status']);

    $out = array();

    foreach ($list as $item)
    {
      $out[] = array(
          'id'     => $item->id,
          'Number' => $item->Number,
          'Status' => self::$statuses[$item->Status],
      );
    }

    return $out;
  }

  /**
   * вернёт наименование класса для раскраски статуса
   *
   * @return string
   */
  public function GetStatusColor(): string
  {
    $status = $this->getStatus();
    $class_name = '';
    switch ($status)
    {
      case self::STATUS_ACTIVE:
        $class_name = 'mr-status-active';
        break;
      case self::STATUS_PAUSED:
        $class_name = 'mr-status-paused';
        break;
      case self::STATUS_STOPPED:
        $class_name = 'mr-status-stopped';
        break;
      case self::STATUS_CONTINUED:
        $class_name = 'mr-status-continued';
        break;
      case self::STATUS_REOPENED:
        $class_name = 'mr-status-reopened';
        break;
      case self::STATUS_ARCHIVED:
        $class_name = 'mr-status-archived';
        break;
    }

    return $class_name;
  }
}