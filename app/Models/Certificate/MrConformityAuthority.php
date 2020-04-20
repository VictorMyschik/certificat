<?php


namespace App\Models\Certificate;


use App\Helpers\MrDateTime;
use App\Models\MrUser;
use App\Models\ORM;
use App\Models\References\MrCountry;
use Illuminate\Support\Facades\DB;

/**
 * Орган по оценке соответствия
 *
 * Органы по оценке соответствия, осуществляющие работы по оценке соответствия продукции, включенной в единый перечень
 * продукции, подлежащей обязательному подтверждению соответствия с выдачей сертификатов соответствия и деклараций о
 * соответствии по единой форме, утвержденный Решением Комиссии Таможенного союза от 7 апреля 2011 г. № 620
 *
 * XML: trcdo:ConformityAuthorityV2Details
 */
class MrConformityAuthority extends ORM
{
  public static $mr_table = 'mr_conformity_authority';
  public static $className = MrConformityAuthority::class;
  protected $table = 'mr_conformity_authority';

  protected static $dbFieldsMap = array(
    'CountryID', // businessEntityName max 300
    'Name',//номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    'ConformityAuthorityId', // кодовое обозначение страны, в которой зарегистрирован орган по оценке соответствия
    'DocumentNumber', // номер документа, подтверждающего аккредитацию органа по оценке соответствия
    'DocumentDate', // дата регистрации документа подтверждающего аккредитацию органа по оценке соответствия
    'OfficerDetailsID',// Руководитель органа по оценке соответствия
    'AddressID'//Адрес
  );

  public function before_save()
  {
    $data = DB::table(self::$mr_table)
      ->where('CountryID', $this->getCountry()->id())
      ->where('Name', $this->getName())
      ->where('ConformityAuthorityId', $this->getConformityAuthorityId())
      ->where('DocumentNumber', $this->getDocumentNumber())
      ->first(['id']);

    if($data)
    {
      $this->id = $data->id;
    }
  }

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  public static function loadBy($value, $field = 'id'): ?MrConformityAuthority
  {
    return parent::loadBy((string)$value, $field);
  }

  //номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  //номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
  public function getConformityAuthorityId(): string
  {
    return $this->ConformityAuthorityId;
  }

  public function setConformityAuthorityId(string $value)
  {
    $this->ConformityAuthorityId = $value;
  }

  // кодовое обозначение страны, в которой зарегистрирован орган по оценке соответствия
  public function getCountry(): MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(int $value)
  {
    $this->CountryID = $value;
  }

  // номер документа, подтверждающего аккредитацию органа по оценке соответствия
  public function getDocumentNumber(): string
  {
    return $this->DocumentNumber;
  }

  public function setDocumentNumber(string $value)
  {
    $this->DocumentNumber = $value;
  }

  // дата регистрации документа подтверждающего аккредитацию органа по оценке соответствия
  public function getDocumentDate(): MrDateTime
  {
    return $this->getDateNullableField('DocumentDate');
  }

  public function setDocumentDate($value)
  {
    return $this->setDateNullableField($value, 'DocumentDate');
  }

  // Руководитель органа по оценке соответствия
  public function getOfficerDetails(): ?MrFio
  {
    return MrFio::loadBy($this->OfficerDetailsID);
  }

  public function setOfficerDetailsID(?int $value)
  {
    $this->OfficerDetailsID = $value;
  }

  /**
   * Адрес органа
   *
   * @return MrAddress|null
   */
  public function getAddress(): ?MrAddress
  {
    return MrAddress::loadBy($this->AddressID);
  }

  public function setAddressID(?int $value)
  {
    $this->AddressID = $value;
  }
}