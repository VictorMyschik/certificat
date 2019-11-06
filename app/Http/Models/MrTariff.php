<?php


namespace App\Http\Models;



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

  const MEASURE_MONTH = 1;
  const MEASURE_SERT_AMOUNT = 2;

  private static $measures = array(
    self::MEASURE_MONTH => 'Помесячная оплата',
    self::MEASURE_SERT_AMOUNT => 'По количеству сертификатов',
  );


  public static function getMeasureList()
  {
    return self::$measures;
  }

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

  // Тип оплаты
  public function getMeasure(): int
  {
    return $this->Measure;
  }

  public function getMeasureName(): string
  {
    return self::getMeasureList()[$this->Measure];
  }


  public function setMeasure(int $value)
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

  /**
   * @return MrTariff[]
   */
  public static function SelectList(): ?array
  {
    $out = array();
    foreach (MrTariff::GetAll() as $tariff)
    {
      $out[$tariff->id()] = $tariff->getName();
    }
    return $out;
  }
}