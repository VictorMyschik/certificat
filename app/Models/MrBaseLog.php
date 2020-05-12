<?php

namespace App\Models;

use App\Helpers\MrDateTime;
use SimpleXMLElement;

/**
 * Запись всех изменений БД
 */
class MrBaseLog extends ORM
{
  public static $className = MrBaseLog::class;
  protected $table = 'mr_base_log';

  public static $ignoring_tables = array(
    'mr_log_ident',
    'mr_base_log',
    'mr_user'
  );

  protected static $dbFieldsMap = array(
    'LogIdentID',
    'RowId',
    'TableName',
    'Field',
    'Value',
    //'WriteDate',
  );

  // Посетитель
  public function getLogIdent(): ?MrLogIdent
  {
    return MrLogIdent::loadBy($this->LogIdentID);
  }

  public function setLogIdentID(int $value): void
  {
    $this->LogIdentID = $value;
  }

  // Наименование таблицы
  public function getTName(): string
  {
    return $this->TableName;
  }

  public function setTName(string $value): void
  {
    $this->TableName = $value;
  }

  // Наименование поля в таблице
  public function getField(): string
  {
    return $this->Field;
  }

  public function setField(string $value): void
  {
    $this->Field = $value;
  }

  // Новое значение
  public function getValue(): ?string
  {
    return $this->Value;
  }

  public function setValue($value): void
  {
    if($value instanceof MrDateTime)
    {
      $value = $value->getMysqlDateTime();
    }

    if($value instanceof SimpleXMLElement)
    {
      $value = 'xml';
    }

    $this->Value = $value;
  }

  // ID строки
  public function getRowId(): int
  {
    return $this->RowId;
  }

  public function setRowId(int $value): void
  {
    $this->RowId = $value;
  }

  // Дата создания/обновления записи
  public function getWriteDate(): MrDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }

  //////////////////////////////////////////////////////////////
  public static function SaveData(string $table, int $id, array $data)
  {
    if(!in_array($table, MrBaseLog::$ignoring_tables))
    {
      if(count($data))
      {
        foreach ($data as $key => $item)
        {
          $log = new MrBaseLog();
          $log->setTName($table);
          $log->setLogIdentID(MrLogIdent::$ident_id);
          $log->setRowId($id);
          $log->setField($key);
          $log->setValue($item);

          $log->save_mr();
        }
      }
      else
      {
        $log = new MrBaseLog();
        $log->setTName($table);
        $log->setLogIdentID(MrLogIdent::$ident_id);
        $log->setRowId($id);
        $log->setField('del');
        $log->setValue('del');

        $log->save_mr();
      }
    }
  }
}