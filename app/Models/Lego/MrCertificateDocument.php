<?php

namespace App\Models\Lego;

use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrDocument;
use App\Models\ORM;

class MrCertificateDocument extends ORM
{
  public static $className = MrCertificateDocument::class;
  protected $table = 'mr_certificate_document';

  protected $fillable = array(
    'CertificateID',
    'DocumentID',
  );

  public function after_save()
  {
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

  public function getDocument(): MrDocument
  {
    return MrDocument::loadBy($this->DocumentID);
  }

  public function setDocumentID(int $value): void
  {
    $this->DocumentID = $value;
  }
}