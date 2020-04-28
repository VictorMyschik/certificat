<?php

namespace App\Models\Certificate;

use App\Models\ORM;

/**
 * Общие данные о сертифицируемом продукте
 */
class MrProduct extends ORM
{
  public static $mr_table = 'mr_product';
  public static $className = MrProduct::class;
  protected $table = 'mr_product';

  protected static $dbFieldsMap = array(
    'CertificateID',
    'Name',
    'EANCommodityId',
  );

  public static function loadBy($value, $field = 'id'): ?MrProduct
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value): void
  {
    $this->CertificateID = $value;
  }

  /**
   * Наименование
   *
   * @return string
   */
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value): void
  {
    $this->Name = $value;
  }

  /**
   * Европейский номер товара, предназначенный для передачи штрихкода товара и производителя
   *
   * @return string
   */
  public function getEANCommodityId(): ?string
  {
    return $this->EANCommodityId;
  }

  public function setEANCommodityId(?string $value): void
  {
    $this->EANCommodityId = $value;
  }
}