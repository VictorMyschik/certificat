<?php


namespace App\Models\Certificate;


use App\Helpers\MrDateTime;
use App\Models\ORM;

class MrDocument extends ORM
{
  public static $mr_table = 'mr_document';
  public static $className = MrDocument::class;
  protected $table = 'mr_document';

  protected static $dbFieldsMap = array(
    'Kind',
    'Name',
    'Number',
    'Date',
    'DateFrom',
    'DateTo',
    'Organisation',
    'Description',
    'IsInclude',
  );

  public static function loadBy($value, $field = 'id'): ?MrDocument
  {
    return parent::loadBy((string)$value, $field);
  }

  const KIND_UNKNOWN = 0;
  const KIND_GUARANTEE = 1;
  const KIND_EQUALS = 2;

  private static $kinds = array(
    self::KIND_GUARANTEE => 'Документы, обеспечивающие соблюдение требований',
    self::KIND_EQUALS    => 'Документы, подтверждающие соответствие требованиям',
  );

  public static function getKindLis(): array
  {
    return self::$kinds;
  }

  public function getKind(): int
  {
    return $this->Kind;
  }

  public function getKindName(): string
  {
    return self::getKindLis()[$this->getKind()];
  }

  public function setKind(int $value): void
  {
    $this->Kind = $value;
  }

  // Наименование документа
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value): void
  {
    $this->Name = $value;
  }

  // Номер документа
  public function getNumber(): ?string
  {
    return $this->Number;
  }

  public function setNumber(?string $value): void
  {
    $this->Number = $value;
  }

  public function getDate(): ?MrDateTime
  {
    return $this->getDateNullableField('Date');
  }

  public function setDate($value): void
  {
    $this->setDateNullableField($value, 'Date');
  }

  public function getDateFrom(): ?MrDateTime
  {
    return $this->getDateNullableField('DateFrom');
  }

  public function setDateFrom($value): void
  {
    $this->setDateNullableField($value, 'DateFrom');
  }

  public function getDateTo(): ?MrDateTime
  {
    return $this->getDateNullableField('DateTo');
  }

  public function setDateTo($value): void
  {
    $this->setDateNullableField($value, 'DateTo');
  }

  // Организация, выдавшая документ
  public function getOrganisation(): ?string
  {
    return $this->Organisation;
  }

  public function setOrganisation(?string $value): void
  {
    $this->Organisation = $value;
  }

  // Описание документа
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  public function isInclude(): bool
  {
    return (bool)$this->IsInclude;
  }

  public function setIsInclude(bool $value): void
  {
    $this->setIsInclude = $value;
  }
}