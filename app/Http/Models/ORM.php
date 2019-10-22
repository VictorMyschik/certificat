<?php

namespace App\Models;

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
      DB::table(static::$mr_table)->where('id', '=', $object->id)->update($array);

      $out =  $object->id;
    }
    else
    {
      $out = DB::table(static::$mr_table)->insertGetId($array);
    }

    $this->FlushCache();

    return $out;
  }

  private function FlushCache()
  {
    foreach(static::$mr_caches as $mr_cache)
    {
      Cache::forget($mr_cache);
    }
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

      $this->FlushCache();

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