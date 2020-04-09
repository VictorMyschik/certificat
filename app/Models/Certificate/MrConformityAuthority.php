<?php


namespace App\Models\Certificate;


use App\Helpers\MrDateTime;
use App\Models\ORM;
use App\Models\References\MrCountry;

/**
 * Орган по оценке соответствия
 * XML: trcdo:ConformityAuthorityV2Details
 */
class MrConformityAuthority extends ORM
{
  public static $mr_table = 'mr_conformity_authority';
  public static $className = MrConformityAuthority::class;
  protected $table = 'mr_conformity_authority';

  protected static $dbFieldsMap = array(
    'ConformityAuthorityId',//номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    'CountryID', // кодовое обозначение страны, в которой зарегистрирован орган по оценке соответствия
    'DocumentNumber', // номер документа, подтверждающего аккредитацию органа по оценке соответствия
    'DocumentDate', // дата регистрации документа подтверждающего аккредитацию органа по оценке соответствия
    'OfficerDetailsID',// Руководитель органа по оценке соответствия
  );

  public static function loadBy($value, $field = 'id'): ?MrConformityAuthority
  {
    return parent::loadBy((string)$value, $field);
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
  public function getOfficerDetails(): MrFio
  {
    return MrFio::loadBy($this->OfficerDetailsID);
  }

  public function setOfficerDetailsID(int $value)
  {
    $this->OfficerDetailsID = $value;
  }
}