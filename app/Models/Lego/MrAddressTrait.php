<?php


namespace App\Models\Lego;


use App\Models\Certificate\MrAddress;

trait MrAddressTrait
{

  /**
   * Адрес (юридический)
   */
  public function getAddress1(): ?MrAddress
  {
    return MrAddress::loadBy($this->Address1ID);
  }

  public function setAddress1ID(?int $value)
  {
    $this->Address1ID = $value;
  }

  /**
   * Адрес (фактический)
   */
  public function getAddress2(): ?MrAddress
  {
    return MrAddress::loadBy($this->Address2ID);
  }

  public function setAddress2ID(?int $value)
  {
    $this->Address2ID = $value;
  }
}