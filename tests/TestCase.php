<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  const abc_string = 'abcdefghijklmnopqrstuvwxyz';
  const ABC_string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  const numbers_string = '0123456789';
  const hex_string = self::numbers_string . 'ABCDEF';
  const full_lconly_string = self::numbers_string . self::abc_string;
  const full_string = self::numbers_string . self::ABC_string . self::abc_string;

  protected static function randomIDfromClass(string $classname)
  {
    $query = DB::table($classname::getTableName())->limit(1000)->pluck('id')->toArray();
    $key = array_rand($query);

    return $query[$key];
  }

  protected function randomString($length = 255): string
  {
    $characterset = self::abc_string . self::ABC_string;

    if(!strlen($characterset))
    {
      return '';
    }

    $r = '';

    $unicode_str_length = mb_strlen($characterset);
    $ascii_str_length = strlen($characterset);

    if($unicode_str_length != $ascii_str_length)
    {
      //there are Unicode characters - slow way
      for ($i = 0; $i < $length; $i++)
      {
        $r .= mb_substr($characterset, mt_rand(0, $unicode_str_length - 1), 1);
      }
    }
    else
    {
      //just ASCII characters, can use fast way
      for ($i = 0; $i < $length; $i++)
      {
        $r .= $characterset[mt_rand(0, $ascii_str_length - 1)];
      }
    }

    return $r;
  }
}
