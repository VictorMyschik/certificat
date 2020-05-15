<?php

namespace App\Models\Certificate;

use App\Models\ORM;

class MrTnved extends ORM
{
  public static $className = MrTnved::class;
  protected $table = 'mr_tnved';

  protected $fillable = array(
    'Code',
    'Name',
  );

  public function before_save()
  {
    // Если уже существует
    if($object = $this::loadBy($this->getCode()))
    {
      $this->id = $object->id();
    }
  }

  /**
   * Код ТН ВЭД
   *
   * @return string
   */
  public function getCode(): string
  {
    return $this->Code;
  }

  public function setCode(string $value): void
  {
    $this->Code = $value;
  }

  /**
   * Наименование
   *
   * @return string|null
   */
  public function getName(): ?string
  {
    return $this->Name;
  }

  public function setName(?string $value): void
  {
    $this->Name = $value;
  }
}