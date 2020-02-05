<?php

namespace App\Http\Models;

use App\Http\Controllers\Helpers\MrCacheHelper;
use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ORM extends Model
{
  protected static $mr_table;
  protected static $dbFieldsMap;
  protected static $className;
  protected $id = 0;

  /**
   * @return array ::$className[]
   */
  public static function GetAll()
  {
    $list_id = DB::table(static::$mr_table)->get(['*']);

    return self::LoadArray($list_id, static::$className);
  }

  /**
   * @param int $count
   * @return mixed
   */
  public static function GetAllPaginate(int $count = 10)
  {
    $list = static::$className::paginate($count)->onEachSide(1);
    $data = array();
    foreach ($list->items() as $item)
    {
      $data[] = $item->attributes;
    }

    $out['items'] = self::LoadArray($data, static::$className);
    $out['links'] = $list->links();

    return $out;
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

  /**
   * Конвертирует объект Eloquem в обьет Mr
   *
   * @param $out
   * @param string $class_name
   * @return self::$class_name
   */
  public static function convertToMr($out, string $class_name = null): object
  {
    $object = $class_name ? new $class_name() : new static();

    foreach ($out as $key => $value)
    {
      $object->$key = $value;
    }

    return $object;
  }

  protected function convertMrToArray(): array
  {
    $out = array();

    foreach (static::$dbFieldsMap as $properties)
    {
      if(is_object($this->$properties))
      {
        if(!isset($this->$properties->id))
        {
          $out[$properties] = $this->$properties;
        }
        else
        {
          $out[$properties] = $this->$properties->id;
        }
      }
      else
      {
        $out[$properties] = $this->$properties;
      }
    }

    return $out;
  }

  /**
   * Загрузка объекта
   *
   * @param string $value
   * @param string $field
   * @return object|null
   */
  public static function loadBy(string $value, string $field = 'id')
  {
    if($field == 'id')
    {
      $out = MrCacheHelper::GetCachedObjectByID((int)$value, static::$mr_table, function () use ($field, $value) {
        return DB::table(static::$mr_table)->where($field, '=', $value)->orderBy('id', 'DESC')->get()->first();
      });

    }
    else
    {
      $out = DB::table(static::$mr_table)->where($field, '=', $value)->orderBy('id', 'DESC')->get()->first();
    }

    if($out)
    {
      $mr_object = self::convertToMr($out);
      // Вставка имени кэшированного объекта
      $mr_object->CachedKey = (string)(static::$mr_table . '|' . $mr_object->id());
      $mr_object->original = $out;

      return $mr_object;
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
      $out[] = self::convertToMr($item, $class);
    }

    return $out;
  }

  public function save_mr(): ?int
  {
    $array = $this->convertMrToArray();

    if($this->id)
    {
      $array = $this->equals_data();

      if(count($array))
      {
        DB::table(static::$mr_table)->where('id', '=', (int)$this->id)->update($array);
        // Запись в лог изменений БД
        MrBaseLog::SaveData(static::$mr_table, $this->id, $array);
      }

      $last_id = (int)$this->id;
    }
    else
    {
      $last_id = DB::table(static::$mr_table)->insertGetId($array);
      // Запись в лог изменений БД
      MrBaseLog::SaveData(static::$mr_table, $last_id, $array);
    }

    if(method_exists($this, 'after_save'))
    {
      $this->id = $last_id;
      $this->after_save();
    }

    Cache::forget($this->CachedKey);

    return $last_id;
  }

  /**
   * Отбор данных для сохранения
   *
   * @return array
   */
  public function equals_data(): array
  {
    $out = array();
    $attributes = $this->attributes;
    $attributes['id'] = $this->id();
    foreach ($this->original as $key => $property)
    {
      if($attributes[$key] != $property)
      {
        $out[$key] = $attributes[$key];
      }
    }

    return $out;
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

      if(method_exists($this, 'after_delete'))
      {
        $this->after_delete();
      }

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

  protected function getDateNullableField(string $field): ?MtDateTime
  {
    return $this->$field ? MtDateTime::fromValue($this->$field) : null;
  }

  /**
   * @param $value
   * @param $field
   * @throws \Exception
   */
  protected function setDateNullableField($value, $field)
  {
    if($value)
    {
      if($value instanceof MtDateTime)
      {
        //nothing to do
      }
      elseif($value instanceof \DateTime)
      {
        $value = new MtDateTime($value->format(MtDateTime::MYSQL_DATETIME));
      }
      else
      {
        $value = MtDateTime::fromValue($value);
      }
    }
    else
    {
      $value = null;
    }

    $this->$field = MtDateTime::fromValue($value);
  }

  /**
   * Клонирование объекта
   */
  public function clone(): object
  {
    $array = array();

    foreach (static::$dbFieldsMap as $properties)
    {
      if($this->$properties)
      {
        if(is_object($this->$properties))
        {
          if(!isset($this->$properties->id))
          {
            $array[$properties] = $this->$properties;
          }
          else
          {
            $array[$properties] = $this->$properties->id;
          }
        }
        else
        {
          $array[$properties] = $this->$properties;
        }
      }
    }

    $last_id_out = DB::table(static::$mr_table)->insertGetId($array);
    return static::$className::loadBy($last_id_out);
  }

  /**
   * Сравнивает два объекта по ID и наименованию класса
   *
   * @param object $object
   * @return bool
   */
  public function equals(?object $object): bool
  {
    if(!is_object($object) || !$object)
    {
      return false;
    }

    if($this->id() == $object->id())
    {
      if($this::$className == $object::$className)
      {
        return true;
      }
    }

    return false;
  }

  public function flash()
  {
    $id = $this->id();
    $table_name = $this::$mr_table;
    Cache::forget($table_name . '|' . $id);
  }
}