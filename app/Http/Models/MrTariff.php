<?php


namespace App\Http\Models;


use App\Models\ORM;

class MrTariff extends ORM
{
  public static $mr_table = 'mr_tariff';
  protected static $className = MrTariff::class;
  protected static $dbFieldsMap = array(
    'Name',
    'Measure',
    'Cost',
    'Description',
    'Category',
  );

  const CATEGORY_API = 1;
  const CATEGORY_SEARCH = 2;

  private static $categories = array(
    self::CATEGORY_API => 'API доступ к системе',
    self::CATEGORY_SEARCH => 'Отслеживание состояния сертификатов',
  );

  public static function loadBy($value, $field = 'id'): ?MrTariff
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canDelete(): bool
  {
    $offices = MrOffice::GetAll();

    /** @var MrOffice[] $offices */
    foreach ($offices as $item)
    {
      foreach ($item->GetTariff() as $tariff)
      {
        if($this->id() == $tariff->id())
        {
          return false;
        }
      }
    }

    return true;
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public static function getCategoryList(): array
  {
    return self::$categories;
  }

  public function getCategory(): int
  {
    return $this->Category;
  }

  public function getCategoryName(): string
  {
    return $this->getCategorylist()[$this->Category];
  }

  public function getCost(): float
  {
    return $this->Cost;
  }

  public function setCost(float $value): float
  {
    return $this->Cost = $value;
  }

  public function setCategory(int $value)
  {
    $this->Category = $value;
  }

  // Название тарифного плана
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }


  // Название тарифного плана
  public function getMeasure(): string
  {
    return $this->Measure;
  }

  public function setMeasure(string $value)
  {
    $this->Measure = $value;
  }

  // Примечание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

////////////////////////////////////////////////////////////////////////////
  public function GetFullName(): string
  {
    $r = '';
    $r .= $this->getName();
    return $r;
  }
}