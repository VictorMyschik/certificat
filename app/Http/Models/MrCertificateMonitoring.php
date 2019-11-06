<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;

class MrCertificateMonitoring extends ORM
{
  public static $mr_table = 'mr_certificate_monitoring';
  public static $className = MrCertificateMonitoring::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'UserInOfficeID',
    'CertificateID',
    'Description',
    //'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrCertificateMonitoring
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public function getUserInOffice(): MrUserInOffice
  {
    return MrUserInOffice::loadBy($this->UserInOfficeID);
  }

  public function setUserInOfficeID(int $value)
  {
    $this->UserInOfficeID = $value;
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value)
  {
    $this->CertificateID = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  public function getWriteDate(): MtDateTime
  {
    return MtDateTime::fromValue($this->WriteDate);
  }
}
