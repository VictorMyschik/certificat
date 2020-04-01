<?php


namespace App\Helpers;


use App\Models\ORM;
use Illuminate\Support\Facades\Cache;

class MrCacheHelper extends Cache
{
  /**
   * Load objects array
   *
   * @param string $key
   * @param string $class_name
   * @param callable $ids
   * @return array
   */
  public static function GetCachedObjectList(string $key, string $class_name, callable $ids): array
  {
    $ids = Cache::rememberForever($key, function () use ($ids) {
      return $ids();
    });

    $out = array();
    foreach ($ids as $id)
    {
      $object_name = $class_name;

      /** @var object $object_name */
      $out[] = $object = $object_name::loadBy($id);
    }

    return $out;
  }

  /**
   * Get text
   *
   * @param string $key
   * @param callable $text
   * @return mixed
   */
  public static function GetCachedField(string $key, callable $text): ?string
  {
    return Cache::rememberForever($key, function () use ($text) {
      return $text();
    });
  }

  /**
   * Get object
   *
   * @param string $key ключ
   * @param string $class_name класс который надо загрузить
   * @param callable $object
   * @return object
   */
  public static function GetCachedObject(string $key, string $class_name, callable $object)
  {
    $object = Cache::rememberForever($key, function () use ($object) {
      return $object();
    });

    return ORM::convertToMr($object, $class_name);
  }

  /**
   * Получение объекта по ID из кэша
   *
   * @param int $id
   * @param string $table
   * @param callable $object
   * @return mixed
   */
  public static function GetCachedObjectByID(int $id, string $table, callable $object)
  {
    $cache_key = $table . '_' . $id;
    return Cache::rememberForever($cache_key, function () use ($object) {
      return $object();
    });
  }
}