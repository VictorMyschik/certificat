<?php

namespace App\Models;

use App\Http\Models\MrBaseLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ORM extends Model
{
  protected static $mr_table;
  protected static $dbFieldsMap;
  protected static $className;
  protected static $mr_caches = array();

  public function __construct()
  {
    $this->id = 0;
  }

  public static function GetAll()
  {
    $lisd_id = DB::table(static::$mr_table)->get(['*']);

    return self::LoadArray($lisd_id, static::$className);
  }

  /**
   * Удалить все записи в таблице
   */
  public static function AllDelete()
  {
    DB::table(static::$mr_table)->truncate();
  }

  /**
   * Количество записей в таблице
   *
   * @return int
   */
  public static function getCount(): int
  {
    return DB::table(static::$mr_table)->count();
  }

  public static function loadBy(string $value, string $field = 'id')
  {
    $object = new static();
    $out = DB::table(static::$mr_table)->where($field, '=', $value)->orderBy('id', 'DESC')->get()->first();

    if($out)
    {
      foreach ($out as $key => $value)
      {
        $object->$key = $value;
      }

      return $object;
    }

    return null;
  }

  /**
   * Конвертация массива объектов Laravel в массив Mr
   *
   * @param array $list
   * @param       $class
   * @return object[]
   */
  public static function LoadArray($list, string $class): array
  {
    $out = array();
    foreach ($list as $item)
    {
      $object = new $class();
      foreach ($item as $key => $value)
      {
        $object->$key = $value;
      }

      $out[] = $object;
    }

    return $out;
  }

  public function mr_save_object($object): ?int
  {
    $array = array();
    $diff = array();

    foreach (static::$dbFieldsMap as $propertis)
    {
      if(is_object($object->$propertis))
      {
        if(!isset($object->$propertis->id))
        {
          $array[$propertis] = $object->$propertis;
        }
        else
        {
          $array[$propertis] = $object->$propertis->id;
        }
      }
      else
      {
        $array[$propertis] = $object->$propertis;
      }
    }

    if($object->id)
    {
      $origin = self::loadBy($object->id);

      $diff = self::equals($origin, $object);
      if(count($diff))
      {
        DB::table(static::$mr_table)->where('id', '=', (int)$object->id)->update($diff);
      }

      $last_id_out = (int)$object->id;
    }
    else
    {
      $last_id_out = DB::table(static::$mr_table)->insertGetId($array);
      $diff = $array;
    }

    MrBaseLog::SaveData(static::$mr_table, $last_id_out, $diff);

    return $last_id_out;
  }

  /**
   * Отбор данных для сохранения
   *
   * @param object $origin
   * @param object $modified
   * @return array
   * @throws \Exception
   */
  private static function equals(object $origin, object $modified): array
  {
    $out = array();

    foreach ($origin->attributes as $orgn_key => $orgn_value)
    {
      if(in_array((string)$orgn_key, array('WriteDate', 'DateLastVisit')))
      {
        continue;
      }

      if($modified->attributes[$orgn_key] instanceof Carbon)
      {
        $or = new Carbon($orgn_value);
        if($modified->attributes[$orgn_key]->format('Y-m-d H:i:s') !== $or->format('Y-m-d H:i:s'))
        {
          $out[$orgn_key] = $modified->attributes[$orgn_key];
        }
      }
      elseif($modified->attributes[$orgn_key] != $orgn_value)
      {
        $out[$orgn_key] = $modified->attributes[$orgn_key];
      }
    }

    return $out;
  }

  // Загрузка по имени класса и ID
  public function GetObject(string $value, string $class_name, string $field_name = 'id')
  {
    return $class_name::loadBy($value, $field_name);
  }

  public function mr_delete(): bool
  {
    if(method_exists($this, 'before_delete'))
    {
      $this->before_delete();
    }

    if($this->getTable() && $this->id())
    {
      DB::table(static::$mr_table)->delete($this->id());

      MrBaseLog::SaveData(static::$mr_table, $this->id(), []);

      return true;
    }
    else
    {
      return false;
    }
  }

  public function id(): ?int
  {
    return $this->id ?: null;
  }
}