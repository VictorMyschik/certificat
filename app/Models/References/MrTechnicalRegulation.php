<?php


namespace App\Models\References;


use App\Models\ORM;

class MrTechnicalRegulation extends ORM
{
  public static $mr_table = 'mr_technical_regulation';
  public static $className = MrTechnicalRegulation::class;
  protected $table = 'mr_technical_regulation';

  protected static $dbFieldsMap = array(
    'Code',
    'Name',
  );

  public static function getReferenceInfo()
  {
    return array(
      'classifier_group' => '',
      'description'      => '',
      'date'             => '',
      'document'         => '',
      'doc_link'         => '',
    );
  }

  public static function getRouteTable()
  {
    return 'list_technical_regulation_table';
  }

  public static function loadBy($value, $field = 'id'): ?MrTechnicalRegulation
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

  /**
   * Наименование
   *
   * @return string
   */
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value)
  {
    $this->Name = $value;
  }
}