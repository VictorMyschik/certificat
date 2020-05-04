<?php

namespace App\Models\Certificate;

use App\Helpers\MrDateTime;
use App\Models\ORM;
use App\Models\References\MrMeasure;

/**
 * подробные сведения о продукте
 */
class MrProductInfo extends ORM
{
  public static $mr_table = 'mr_product_info';
  public static $className = MrProductInfo::class;
  protected $table = 'mr_product_info';

  protected static $dbFieldsMap = array(
    'ProductID',
    'MeasureID',
    'InstanceId',//Заводской номер единичного изделия или обозначение у группы одинаковых единиц продукции
    'Name',
    'Description',
    'ManufacturedDate',
    'ExpiryDate',
    'TnvedID',
  );

  public static function loadBy($value, $field = 'id'): ?MrProductInfo
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  public function getProduct(): MrProduct
  {
    return MrProduct::loadBy($this->ProductID);
  }

  public function setProductID(int $value): void
  {
    $this->ProductID = $value;
  }

  public function getMeasure(): ?MrMeasure
  {
    return MrMeasure::loadBy($this->MeasureID);
  }

  public function setMeasureID(?int $value): void
  {
    $this->MeasureID = $value;
  }

  /**
   * //Заводской номер единичного изделия или обозначение у группы одинаковых единиц продукции
   *
   * @return string
   */
  public function getInstanceId(): ?string
  {
    return $this->InstanceId;
  }

  public function setInstanceId(?string $value): void
  {
    $this->InstanceId = $value;
  }

  /**
   * Наименование
   *
   * @return string
   */
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value): void
  {
    $this->Name = $value;
  }

  /**
   * Дополнительные сведения о продукции, обеспечивающие ее идентификацию
   *
   * @return string
   */
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  /**
   * Дата производства
   *
   * @return MrDateTime|null
   */
  public function getManufacturedDate(): ?MrDateTime
  {
    return $this->getDateNullableField('ManufacturedDate');
  }

  public function setManufacturedDate($value): void
  {
    $this->setDateNullableField($value, 'ManufacturedDate');
  }

  /**
   * Дата истечения срока годности
   *
   * @return MrDateTime|null
   */
  public function getExpiryDate(): ?MrDateTime
  {
    return $this->getDateNullableField('ExpiryDate');
  }

  public function setExpiryDate($value): void
  {
    $this->setDateNullableField($value, 'ExpiryDate');
  }

  /**
   * ТН ВЭД
   *
   * @return MrTnved|null
   */
  public function getTnved(): ?MrTnved
  {
    return MrTnved::loadBy($this->TnvedID);
  }

  public function GetTnvedExt(): ?MrTnved
  {
    return $this->getTnved() ?: $this->getProduct()->getTnved();
  }

  public function setTnved(?int $value): void
  {
    $this->TnvedID = $value;
  }
}