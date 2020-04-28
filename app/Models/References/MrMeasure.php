<?php

namespace App\Models\References;

use App\Models\ORM;

class MrMeasure extends ORM
{
  public static $mr_table = 'mr_measure';
  public static $className = MrMeasure::class;
  protected $table = 'mr_measure';

  protected static $dbFieldsMap = array(
    'Code',
    'TextCode',
    'Name',
  );

  public static function getReferenceInfo()
  {
    return array(
      'classifier_group' => 'Классификаторы для заполнения таможенных деклараций',
      'description'      => 'Классификатор предназначен для классификации и кодирования информации о единицах измерения физических величин',
      'date'             => '30.09.2016',
      'document'         => 'О классификаторах, используемых для заполнения таможенных деклараций Решение №378 (имеются изменения и дополнения: Решения Комиссии Таможенного союза №№ 441, 719, 858, 906, Решение Совета Евразийской экономической комиссии № 9)',
      'doc_link'         => 'https://docs.eaeunion.org/_layouts/15/Portal.EEC.NPB/Pages/RedirectToDisplayForm.aspx?mode=Document&UseSearch=1&docId=6690653a-2f1d-4428-b6fc-cf43fa5d4095',
    );
  }

  public static function getRouteTable()
  {
    return 'list_measure_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrMeasure
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

  /**
   * Наименование
   *
   * @return string
   */
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }
}