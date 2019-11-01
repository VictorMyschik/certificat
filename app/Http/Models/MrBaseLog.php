<?php


namespace App\Http\Models;


use App\Models\MrLogIdent;
use App\Models\ORM;
use Carbon\Carbon;

/**
 * Запись всех изменений БД
 */
class MrBaseLog extends ORM
{
  public static $mr_table = 'mr_base_log';
  public static $className = MrBaseLog::class;
  protected static $mr_caches = array();
  protected $id = 0;

  private static $ignoring_tables = array(
    'mr_log_ident',
    'mr_base_log',
    'mr_users'
  );

  protected static $dbFieldsMap = array(
    'LogIdentID',
    'RowId',
    'TableName',
    'Field',
    'Value',
    //'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrBaseLog
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  // Посетитель
  public function getLogIdent(): ?MrLogIdent
  {
    return MrLogIdent::loadBy($this->LogIdentID);
  }

  public function setLogIdentID(int $value)
  {
    $this->LogIdentID = $value;
  }

  // Наименование таблицы
  public function getTableName(): string
  {
    return $this->TableName;
  }

  public function setTableName(string $value)
  {
    $this->TableName = $value;
  }

  // Наименование поля в таблице
  public function getField(): string
  {
    return $this->Field;
  }

  public function setField(string $value)
  {
    $this->Field = $value;
  }

  // Новое значение
  public function getValue(): ?string
  {
    return $this->Value;
  }

  public function setValue(?string $value)
  {
    $this->Value = $value;
  }

  // ID строки
  public function getRowId(): int
  {
    return $this->RowId;
  }

  public function setRowId(int $value)
  {
    $this->RowId = $value;
  }

  // Дата создания/обновления записи
  public function getWriteDate(): Carbon
  {
    return new Carbon($this->WriteDate);
  }

  //////////////////////////////////////////////////////////////
  public static function SaveData(string $table, int $id, array $data)
  {
    if(!in_array($table, self::$ignoring_tables))
    {
      if(count($data))
      {
        foreach ($data as $key => $item)
        {
          $log = new MrBaseLog();
          $log->setTableName($table);
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
        $log->setTableName($table);
        $log->setLogIdentID(MrLogIdent::$ident_id);
        $log->setRowId($id);
        $log->setField('del');
        $log->setValue('del');

        $log->save_mr();
      }
    }
  }
}