<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrBackup extends ORM
{
  public static function recovery(array $data, string $table_name)
  {
    DB::table($table_name)->delete();

    foreach ($data as $item)
    {
      DB::table($table_name)->insert($item);
      Cache::forget($table_name . '_count_rows');
    }
  }
}