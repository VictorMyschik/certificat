<?php


namespace App\Http\Controllers\Helpers;


use Carbon\Carbon;

class MrDateTimeHelper extends Carbon
{
  public static function GetFromToDate(?Carbon $from, ?Carbon $to): string
  {
    $r = '';

    if($from && $to)
    {
      if($from->diff($to)->days == 0)
      {
        return $from->format('d.m.Y');
      }
    }

    if($from)
      $r .= $from->format('d.m.Y');

    if(strlen($r))
      $r .= ' - ';

    if($to)
      $r .= $to->format('d.m.Y');

    return $r;
  }


}