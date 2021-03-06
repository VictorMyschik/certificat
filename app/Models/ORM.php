<?php

namespace App\Models;

use App\Helpers\MrCacheHelper;
use App\Helpers\MrDateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ORM extends Model
{
  protected $fillable;
  protected $id = 0;

  public static function getFieldMap(): array
  {
    $class_name = static::class;
    $object = new $class_name();

    return $object->fillable;
  }

  public function canEdit()
  {
    $user = MrUser::me();

    if($user && $user->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  public static function Select(array $fields = array())
  {
    if(!count($fields))
    {
      $fields[] = '*';
    }

    // Base parametrise
    $field_name = self::getTableName() . '.' . 'id';
    $sort = 'asc';

    foreach (explode('&', request()->getQueryString()) as $item)
    {
      $param = explode('=', $item);
      if($param[0] == 'sort' && ($param[1] == 'asc' || $param[1] == 'desc'))
      {
        $sort = $param[1];
      }
      elseif($param[0] == 'field' && $param[1])
      {
        $field_name = $param[1];

        if(!strpos($param[1], '.'))
        {
          $field_name = self::getTableName() . '.' . $field_name;
        }
      }
    }

    return DB::table(self::getTableName())->select($fields)->orderBy($field_name, $sort);
  }

  public static function getTableName(): string
  {
    return with(new static)->getTable();
  }

  /**
   * Удалить все записи в таблице
   */
  public static function AllDelete()
  {
    DB::table(static::getTableName())->truncate();
  }

  /**
   * Load object (get first result)
   *
   * @param string $value
   * @param string $field
   * @return static|object|null
   */
  public static function loadBy(?string $value, string $field = 'id')
  {
    if(!$value)
    {
      return null;
    }

    // If field 'id' -> can save in cache
    if($field == 'id')
    {
      return MrCacheHelper::GetCachedObject((int)$value, self::getTableName(), function () use ($field, $value) {
        $class_name = static::class;
        return $class_name::where($field, $value)->get()->last();
      });
    }
    else
    {
      $class_name = static::class;
      return $class_name::where($field, $value)->get()->last();
    }
  }

  /**
   * Загрузи или умри
   *
   * @param $value
   * @param $field
   * @return static|object
   */
  public static function loadByOrDie(?string $value, string $field = 'id')
  {
    if(!$object = self::loadBy($value, $field))
    {
      abort(response('Object not loaded:"' . $value . '" by ' . $field, 500));
    }

    return $object;
  }

  /**
   * Clear cache object
   */
  public function CacheObjectFlush(): void
  {
    $id = $this->id();
    $table_name = $this->table;
    Cache::forget($table_name . '_' . $id);
  }

  public function flush()
  {
    $this->CacheObjectFlush();
  }

  /**
   * Object name for identify in a cache
   *
   * @return string
   */
  public function GetCachedKey(): string
  {
    return (string)(static::getTableName() . '_' . $this->attributes['id']);
  }

  public function id(): ?int
  {
    return $this->attributes['id'] ?? null;
  }

  /**
   * Load objects use cache
   *
   * @param array $conditions
   * @return mixed
   */
  public static function LoadArray(array $conditions): array
  {
    $class_name = static::class;
    $ids = $class_name::where($conditions)->pluck('id');// from DB

    $out = array();
    foreach ($ids as $id)
    {
      $out[] = $class_name::loadBy($id); // from cache, else DB
    }

    return $out;
  }

  /**
   * Reload with flush cache
   *
   * @return ORM|object|null
   */
  public function reload()
  {
    Cache::forget($this->GetCachedKey());
    return self::loadBy($this->id);
  }

  public $timestamps = false;


  public function save_mr(): ?int
  {
    if(method_exists($this, 'before_save'))
    {
      $this->before_save();
    }

    $this->save();

    if(method_exists($this, 'after_save'))
    {
      $this->after_save();
    }

    Cache::forget($this->GetCachedKey());

    return $this->id();
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

    Cache::forget($this->GetCachedKey());

    $this->delete();

    MrBaseLog::SaveData(static::getTableName(), $this->id(), []);

    if(method_exists($this, 'after_delete'))
    {
      $this->after_delete();
    }

    return true;
  }

  protected function getDateNullableField(string $field): ?MrDateTime
  {
    return $this->$field ? MrDateTime::fromValue($this->$field) : null;
  }

  /**
   * @param $value
   * @param $field
   * @throws Exception
   */
  protected function setDateNullableField($value, $field)
  {
    if($value)
    {
      if($value == '0001-01-01T00:00:00')
      {
        $this->$field = null;
        return;
      }

      if($value instanceof \DateTime)
      {
        $value = new MrDateTime($value->format(MrDateTime::MYSQL_DATETIME));
      }
      else
      {
        $value = MrDateTime::fromValue($value);
      }
      $this->$field = $value;
    }
    else
    {
      $this->$field = null;
    }
  }
}