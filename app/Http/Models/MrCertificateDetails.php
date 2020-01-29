<?php


namespace App\Http\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class MrCertificateDetails extends ORM
{
  public static $mr_table = 'mr_certificate_details';
  public static $className = MrCertificateDetails::class;

  protected static $dbFieldsMap = array(
    'CertificateID',
    'Field',
    'Value',
    //'WriteDate'
  );

  public static function loadBy($value, $field = 'id'): ?MrCertificateDetails
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {
    Cache::forget('certificate' . $this->CertificateID);
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value)
  {
    $this->CertificateID = $value;
  }

  public function getField(): string
  {
    return $this->Field;
  }

  public function setField(string $value)
  {
    $this->Field = $value;
  }

  public function getValue(): string
  {
    return $this->Value;
  }

  public function setValue(string $value)
  {
    $this->Value = $value;
  }
  // Дата создания/обновления записи
  public function getWriteDate(): Carbon
  {
    return new Carbon($this->WriteDate);
  }
  //////////////////////////////////////////////////////////////////////


}