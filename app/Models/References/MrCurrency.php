<?php

namespace App\Models\References;

use App\Helpers\MrDateTime;
use App\Models\ORM;

class MrCurrency extends ORM
{
  public static $mr_table = 'mr_currency';
  public static $className = MrCurrency::class;
  protected $table = 'mr_currency';

  protected static $dbFieldsMap = array(
    'Code',
    'TextCode',
    'DateFrom',
    'DateTo',
    'Name',
    'Rounding',
    'Description'
  );

  public static function getReferenceInfo()
  {
    return array(
      'classifier_group' => 'Классификаторы для заполнения таможенных деклараций',
      'description'      => 'классификатор предназначен для классификации и кодирования информации о наименованиях валют',
      'date'             => '01.08.2018',
      'document'         => 'О классификаторах, используемых для заполнения таможенных деклараций Решение №378 (имеются изменения и дополнения: Решения Комиссии Таможенного союза №№ 441, 719, 858, 906, Решение Совета Евразийской экономической комиссии № 9)',
      'doc_link'         => 'https://docs.eaeunion.org/_layouts/15/Portal.EEC.NPB/Pages/RedirectToDisplayForm.aspx?mode=Document&UseSearch=1&docId=6690653a-2f1d-4428-b6fc-cf43fa5d4095',
    );
  }

  public static function getRouteTable()
  {
    return 'list_currency_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrCurrency
  {
    return parent::loadBy((string)$value, $field);
  }

  protected function before_delete()
  {

  }

  //  Цифоровой код
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value)
  {
    $this->Code = $value;
  }

  public function getTextCode(): string
  {
    return $this->TextCode;
  }

  public function setTextCode(string $value)
  {
    $this->TextCode = $value;
  }

  public function getDateFrom(): ?MrDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom($value)
  {
    $this->setDateNullableField($value, 'DateFrom');
  }

  public function getDateTo(): ?MrDateTime
  {
    return $this->getDateNullableField('DateTo');
  }

  public function setDateTo($value)
  {
    $this->setDateNullableField($value, 'DateTo');
  }

  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  public function getRounding(): ?int
  {
    return $this->Rounding;
  }

  public function setRounding(int $value)
  {
    $this->Rounding = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }
}