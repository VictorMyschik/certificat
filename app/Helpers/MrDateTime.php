<?php

namespace App\Helpers;

use DateTimeZone;

class MrDateTime extends \DateTime
{
  const MYSQL = 'Y-m-d H:i:s.u';
  const MYSQL_DATE = 'Y-m-d';
  const MYSQL_DATETIME = 'Y-m-d H:i:s';
  const SHORT_DATE = 'd.m.Y';
  const FULL_TIME = 'H:i:s';
  const SHORT_TIME = 'H:i';

  public function __construct($time = 'now', DateTimeZone $timezone = null)
  {
    parent::__construct($time, $timezone);
  }

  public static function GetFromToDate(?MrDateTime $from, ?MrDateTime $to): string
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
    {
      $r .= 'c ' . $from->format('d.m.Y');
    }

    if($to)
    {
      if(strlen($r))
      {
        $r .= ' - ';
      }

      $r .= 'по ' . $to->format('d.m.Y');
    }

    return $r;
  }

  public static function now(): MrDateTime
  {
    return new MrDateTime();
  }

  public static function fromValue($value, ?string $format = null)
  {
    if(!$value instanceof MrDateTime)
    {
      $value = new MrDateTime($value);
    }

    return $value;
  }


  public function isBefore(MrDateTime $datetime, bool $allow_equal = false): bool
  {
    $d1 = $this->getMysqlDateTime();
    $d2 = $datetime->getMysqlDateTime();

    if($d1 == $d2 && $allow_equal)
    {
      return true;
    }
    else
    {
      return $d1 < $d2;
    }
  }

  public function isAfter(MrDateTime $datetime, bool $allow_equal = false): bool
  {
    $d1 = $this->getMysqlDateTime();
    $d2 = $datetime->getMysqlDateTime();

    if($d1 == $d2 && $allow_equal)
    {
      return true;
    }
    else
    {
      return $d1 > $d2;
    }
  }

  public function getShortDate(): string
  {
    return $this->format(MrDateTime::SHORT_DATE);
  }

  private $full_time = -1;

  public function getFullTime(): string
  {
    if($this->full_time === -1)
    {
      $this->full_time = $this->format(MrDateTime::FULL_TIME);
    }

    return $this->full_time;
  }

  private $short_time = -1;

  public function getShortTime(): string
  {
    if($this->short_time === -1)
    {
      $this->short_time = $this->format(MrDateTime::SHORT_TIME);
    }

    return $this->short_time;
  }

  public function getShortDateFullTime(): string
  {
    return $this->getShortDate() . ' ' . $this->getFullTime();
  }

  public function getShortDateShortTime(): string
  {
    return $this->getShortDate() . ' ' . $this->getShortTime();
  }

  private $mysql_date = -1;

  public function getMysqlDate(): string
  {
    if($this->mysql_date === -1)
    {
      $this->mysql_date = $this->format(MrDateTime::MYSQL_DATE);
    }

    return $this->mysql_date;
  }

  private $mysql_datetime = -1;

  public function getMysqlDateTime(): string
  {
    if($this->mysql_datetime === -1)
    {
      $this->mysql_datetime = $this->format(MrDateTime::MYSQL_DATETIME);
    }

    return $this->mysql_datetime;
  }

  public function getShortDateTitleShortTime()
  {
    $r = "";
    $r .= "<span title='" . $this->getShortTime() . "'>{$this->getShortDate()}</span>";

    return $r;
  }

  #region Research
  private static $time_spent = null;

  public static function Start()
  {
    self::$time_spent = microtime(true);
  }

  public static $spent_result = array();

  public static function StopItem(?string $note)
  {
    if($note)
    {
      self::$spent_result[$note] = sprintf('%.4f sec', microtime(true) - self::$time_spent);
    }
    else
    {
      self::$spent_result[] = sprintf('%.4f sec', microtime(true) - self::$time_spent);
    }
  }

  public static function GetTimeResult(): array
  {
    return self::$spent_result;
  }
  #endregion
}