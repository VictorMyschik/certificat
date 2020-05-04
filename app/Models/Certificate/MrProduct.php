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
    'ManufacturerID',
    'Name',
    'EANCommodityId',
    'TnvedID',
    'Description' // Макс. длина: 4000
  );

  public static function loadBy($value, $field = 'id'): ?MrProduct
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  /**
   * Производитель продукта
   *
   * @return MrManufacturer
   */
  public function getManufacturer(): MrManufacturer
  {
    return MrManufacturer::loadBy($this->ManufacturerID);
  }

  public function setManufacturerID(int $value): void
  {
    $this->ManufacturerID = $value;
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
   * Европейский номер товара, предназначенный для передачи штрих-кода товара и производителя
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

  /**
   * ТН ВЭД
   *
   * @return MrTnved|null
   */
  public function getTnved(): ?MrTnved
  {
    return MrTnved::loadBy($this->TnvedID);
  }

  public function setTnved(?int $value): void
  {
    $this->TnvedID = $value;
  }

  /**
   * Дополнительные сведения о продукции, обеспечивающие ее идентификацию
   *
   * @return string|null
   */
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }
}