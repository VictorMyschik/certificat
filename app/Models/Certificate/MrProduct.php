<?php

namespace App\Models\Certificate;

use App\Helpers\MrCacheHelper;
use App\Models\ORM;
use Illuminate\Support\Facades\DB;

/**
 * Общие данные о сертифицируемом продукте
 */
class MrProduct extends ORM
{
  public static $className = MrProduct::class;
  protected $table = 'mr_product';

  protected $fillable = array(
      'CertificateID',
      'Name',
      'EANCommodityId',
      'TnvedID',
      'Description', // Макс. длина: 4000
      'Hash'
  );

  protected function before_delete()
  {

  }

  public function getHash(): string
  {
    return $this->Hash;
  }

  public function setHash(string $value): void
  {
    $this->Hash = $value;
  }

  /**
   * Производитель продукта
   *
   * @return MrCertificate
   */
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

  //////////////////////////////////////////////////////////

  /**
   * Сведения о товаре
   *
   * @return MrProductInfo[]
   */
  public function GetProductInfo(): array
  {
    return MrCacheHelper::GetCachedObjectList('product_info' . '_' . $this->id() . '_list', MrProductInfo::class, function () {
      return DB::table(MrProductInfo::getTableName())->where('ProductID', $this->id())->pluck('id')->toArray();
    });
  }
}