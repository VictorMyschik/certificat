<?php

namespace App\Models\References;

use App\Models\ORM;

class MrCertificateKind extends ORM
{
  public static $className = MrCertificateKind::class;
  protected $table = 'mr_certificate_kind';

  protected static $dbFieldsMap = array(
    'Code', // 2
    'ShortName',
    'Name', // 255
    'Description', //350
  );

  public static function getReferenceInfo()
  {
    return array(
      'classifier_group' => 'Единая система нормативно-справочной информации Евразийского экономического союза',
      'description'      => 'классификатор предназначен для классификации и кодирования информации о видах документов об оценке соответствия требованиям безопасности продукции и связанных с требованиями к продукции процессов проектирования (включая изыскания), производства, строительства, монтажа, наладки, эксплуатации, хранения, перевозки, реализации и утилизации',
      'date'             => '02.09.2019',
      'document'         => 'О справочниках и классификаторах, используемых для заполнения паспорта транспортного средства (паспорта шасси транспортного средства) и паспорта самоходной машины и других видов техники',
      'doc_link'         => 'https://docs.eaeunion.org/_layouts/15/Portal.EEC.NPB/Pages/RedirectToDisplayForm.aspx?mode=Document&UseSearch=1&docId=211c6ac1-06b7-4ac2-ad7e-77007fba66ae',
    );
  }

  public static function getRouteTable()
  {
    return 'list_certificate_kind_table';
  }

  protected function before_delete()
  {

  }

  //  Цифровой код
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value): void
  {
    $this->Code = $value;
  }

  /**
   * Описание
   *
   * @return string|null
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
   * Краткое наименование
   *
   * @return string
   */
  public function getShortName(): string
  {
    return $this->ShortName;
  }

  public function setShortName(string $value): void
  {
    $this->ShortName = $value;
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
}