<?php


namespace App\Models\Certificate;


use App\Models\Lego\MrAddressTrait;
use App\Models\Lego\MrCommunicateTrait;
use App\Models\ORM;
use App\Models\References\MrCountry;

class MrApplicant extends ORM
{
  use MrAddressTrait;
  use MrCommunicateTrait;

  public static $mr_table = 'mr_applicant';
  public static $className = MrApplicant::class;
  protected $table = 'mr_applicant';

  protected static $dbFieldsMap = array(
    'CountryID',
    'BusinessEntityId',//Код государственной регистрации
    'Name',
    'Address1ID',
    'Address2ID',
    'FioID', // Лицо, принявшее сертификат
    'Hash',
  );

  public static function loadBy($value, $field = 'id'): ?MrApplicant
  {
    return parent::loadBy((string)$value, $field);
  }

  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(?int $value): void
  {
    $this->CountryID = $value;
  }

  // Наименование организации
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value): void
  {
    $this->Name = $value;
  }

  /**
   * ФИО заявителя
   *
   * @return MrFio|null
   */
  public function getFio(): ?MrFio
  {
    return MrFio::loadBy($this->Fio);
  }

  public function setFio(?int $value): void
  {
    $this->Fio = $value;
  }

  public function getHash(): string
  {
    return $this->Hash;
  }

  public function setHash(string $value): void
  {
    $this->Hash = $value;
  }

  public function getBusinessEntityId(): ?string
  {
    return $this->BusinessEntityId;
  }

  public function setBusinessEntityId(?string $value): void
  {
    $this->BusinessEntityId = $value;
  }
}