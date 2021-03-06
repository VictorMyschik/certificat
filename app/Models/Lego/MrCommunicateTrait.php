<?php

namespace App\Models\Lego;

trait MrCommunicateTrait
{
  /**
   * Номер таблицы для сложных объектов
   *
   * @return false|int|string
   */
  public function GetTableKind()
  {
    return array_search($this->getTable(), MrCommunicateInTable::getTableList());
  }

  /**
   * Связь
   *
   * @return MrCommunicateInTable[]
   */
  public function GetCommunicate(): array
  {
    return MrCommunicateInTable::LoadArray(['TableKind' => $this->GetTableKind(), 'RowID' => $this->id()]);
  }

  /**
   * Конверт в простой массив (для API)
   *
   * @return array
   */
  public function GetCommunicateOut(): array
  {
    $out = array();
    foreach ($this->GetCommunicate() as $item)
    {
      $communicate = $item->getCommunicate();
      $out[] = array(
          'kind'    => $communicate->getKindName(),
          'address' => $communicate->getAddress(),
          'icon'    => $communicate->getKindIcon()
      );
    }

    return $out;
  }
}