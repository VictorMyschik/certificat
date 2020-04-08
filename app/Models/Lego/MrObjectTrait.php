<?php


namespace App\Models\Lego;


trait MrObjectTrait
{
  public function getObjectKindName(): string
  {
    return self::getObjectKindList()[$this->getObjectKind()];
  }

  public function getObjectKindModelName(): string
  {
    return self::getKindObjectModelList()[$this->getObjectKind()];
  }

  public function getObjectKind(): int
  {
    return $this->ObjectKind;
  }

  public function setObjectKind(int $value)
  {
    if(isset(self::getKindObjectModelList()[$value]))
    {
      $this->ObjectKind = $value;
    }
    else
    {
      dd($value . 'Тип объекта привязки не известен');
    }
  }
}