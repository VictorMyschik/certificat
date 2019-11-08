<?php


namespace App\Http\Controllers\Helpers;


use Illuminate\Support\Facades\Cache;

class MrCacheHelper extends Cache
{
  public static function GetCachedObjectList(string $key, string $class_name, callable $ids): array
  {
    $qwe = $ids;
    dd($qwe);
    $list_ids = Cache::rememberForever($key, function ($ids) {
      return $ids;
    });

    $out = array();
    foreach ($list_ids as $id)
    {
      $object_name = $class_name;

      /** @var object $object_name */
      $out[] = $object = $object_name::loadBy($id);
    }

    return $out;
  }
}