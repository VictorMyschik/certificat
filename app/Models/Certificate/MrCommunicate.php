<?php

namespace App\Models\Certificate;

use App\Models\ORM;

class MrCommunicate extends ORM
{
  public static $className = MrCommunicate::class;
  protected $table = 'mr_communicate';

  protected static $dbFieldsMap = array(
    'Kind',// Тип: телефон, email, факс...
    'Address',
  );

  const CODE_TE = 1;
  const CODE_FX = 2;
  const CODE_EM = 3;
  const CODE_AO = 4;

  private static $address_kinds = array(
    self::CODE_TE => 'Телефон',
    self::CODE_FX => 'Факс',
    self::CODE_EM => 'Электронная почта',
    self::CODE_AO => 'URL',
  );

  private static $kind_codes = array(
    self::CODE_TE => 'TE',
    self::CODE_FX => 'FX',
    self::CODE_EM => 'EM',
    self::CODE_AO => 'AO',
  );

  private static $kind_icons = array(
    self::CODE_TE => 'fa fa-phone',
    self::CODE_FX => 'fa fa-fax',
    self::CODE_EM => 'fa fa-envelope',
    self::CODE_AO => 'fa fa-url',
  );

  public function getKindIcon()
  {
    return self::$kind_icons[$this->getKind()];
  }

  public static function GetKindCodes(): array
  {
    return self::$kind_codes;
  }

  public function getKindCode(): string
  {
    return self::$kind_codes[$this->getKind()];
  }

  public static function getAddressKinds()
  {
    return self::$address_kinds;
  }

  public function getKind(): int
  {
    return $this->Kind;
  }

  public function getKindName(): string
  {
    return self::getAddressKinds()[$this->Kind];
  }

  public function setKind(int $value): void
  {
    if(isset(self::getAddressKinds()[$value]))
    {
      $this->Kind = $value;
    }
    else
    {
      abort('Неизвестное значение: ' . $value);
    }
  }

  // Адрес
  public function getAddress(): string
  {
    return $this->Address;
  }

  public function setAddress(string $value): void
  {
    $this->Address = $value;
  }

  ///////////////////////////////////////////////////////////////////////

}