<?php

namespace App\Models\Lego;

use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\ORM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MrCommunicateInTable extends ORM
{
  public static $mr_table = 'mr_communicate_in_table';
  public static $className = MrCommunicateInTable::class;
  protected $table = 'mr_communicate_in_table';

  protected static $dbFieldsMap = array(
    'TableKind',
    'RowID',
    'CommunicateID',
  );

  public static function loadBy($value, $field = 'id'): ?MrCommunicateInTable
  {
    return parent::loadBy((string)$value, $field);
  }


  const TABLE_KIND_FIO = 1;
  const TABLE_KIND_AUTHORITY = 2;

  public static function getTableList(): array
  {
    return array(
      self::TABLE_KIND_FIO       => MrFio::$mr_table,
      self::TABLE_KIND_AUTHORITY => MrConformityAuthority::$mr_table,
    );
  }

  public function getTableKind(): int
  {
    return $this->TableKind;
  }

  public function getTableKindName(): string
  {
    return self::getTableList()[$this->getTableKind()];
  }

  public function setTableKind(int $value)
  {
    if(isset(self::getTableList()[$value]))
    {
      $this->TableKind = $value;
    }
    else
    {
      dd('Тип привязки не известен');
    }
  }

  /**
   * ID строки к которй привязан объект
   */
  public function getRow(): int
  {
    return $this->RowID;
  }

  public function setRowID(int $value)
  {
    $this->RowID = $value;
  }

  /**
   * Объект свзяи
   *
   * @return MrCommunicate
   */
  public function getCommunicate(): MrCommunicate
  {
    return MrCommunicate::loadBy($this->CommunicateID);
  }

  public function setCommunicateID(int $value)
  {
    $this->CommunicateID = $value;
  }

  ///////////////////////////////////////////////////////////////////////

  /**
   * @param int $communicative_id
   * @param object $object
   * @return Model|Builder|object|void|null
   */
  public static function GetByObject(int $communicative_id, object $object)
  {
    if($table_kind = $object->GetTableKind())
    {
      $query = DB::table(self::$mr_table)
        ->where('CommunicateID', '=', $communicative_id)
        ->Where('RowID', '=', $object->id())
        ->Where('TableKind', '=', $table_kind);

      return $query->first();
    }
    else
    {
      dd('Тип объекта не опознан');
    }

    return;
  }
}