<?php

namespace App\Models\Certificate;

use App\Helpers\MrDateTime;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use App\Models\Office\MrUserInOffice;
use App\Models\ORM;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificateMonitoring extends ORM
{
  protected $table = 'mr_certificate_monitoring';
  public static $className = MrCertificateMonitoring::class;

  protected $fillable = array(
    'OfficeID',
    'CertificateID',
    'Description',
    //'WriteDate',
  );

  public function before_delete()
  {
    Cache::forget('user_certificate_' . MrUser::me()->id());
  }

  public function getOffice(): MrOffice
  {
    return MrOffice::loadBy($this->OfficeID);
  }

  public function setOfficeID(int $value): void
  {
    $this->OfficeID = $value;
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value): void
  {
    $this->CertificateID = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  public function getWriteDate(): MrDateTime
  {
    return MrDateTime::fromValue($this->WriteDate);
  }

/////////////////////////////////////////////////////////////////////////////////////////////////

}
