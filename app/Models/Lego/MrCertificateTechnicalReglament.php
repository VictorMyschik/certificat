<?php

namespace App\Models\Lego;

use App\Models\Certificate\MrCertificate;
use App\Models\ORM;
use App\Models\References\MrTechnicalReglament;

class MrCertificateTechnicalReglament extends ORM
{
  public static $className = MrCertificateTechnicalReglament::class;
  protected $table = 'mr_certificate_technical_reglament';

  protected $fillable = array(
      'CertificateID',
      'TechnicalReglamentID',
  );

  public function after_save()
  {
    $this->flush();
  }

  public function flush()
  {
    parent::flush();

    $this->getCertificate()->flush();
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value): void
  {
    $this->CertificateID = $value;
  }

  public function getTechnicalReglamentID(): MrTechnicalReglament
  {
    return MrTechnicalReglament::loadByOrDie($this->TechnicalReglamentID);
  }

  public function setTechnicalReglamentID(int $value): void
  {
    $this->TechnicalReglamentID = $value;
  }
}