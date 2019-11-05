<?php

namespace App\Http\Controllers\Helpers;

use DateTimeZone;
use Exception;

class MtDateTime extends \DateTime
{
  const MYSQL = 'Y-m-d H:i:s.u';
  const MYSQL_DATE = 'Y-m-d';
  const MYSQL_DATETIME = 'Y-m-d H:i:s';
  const SHORT_DATE = 'd.m.Y';
  const FULL_TIME = 'H:i:s';
  const SHORT_TIME = 'H:i';

  /**
   * @param string|int $time
   * @param DateTimeZone $timezone
   * @throws Exception
   */
  public function __construct($time = 'now', DateTimeZone $timezone = null)
  {
    if(is_integer($time))
    {
      $time = '@' . $time;
    }
    elseif($time instanceof \DateTime)
    {
      $time = $time->format(self::ISO8601);
    }

    if(!$timezone)
    {
      $timezone = self::getDefaultTimezone();
    }

    parent::__construct($time, $timezone);
  }

  function __toString()
  {
    return $this->toString();
  }

  function toString()
  {
    $format = self::MYSQL;

    if($this->format('u') == 0)
    {
      $format = self::MYSQL_DATETIME;

      if($this->format(self::FULL_TIME) == '00:00:00')
      {
        $format = self::MYSQL_DATE;
      }
    }

    return $this->format($format);
  }


  private static $from_value_cache = array();

  /**
   * Преобразует сроковое или значение в MtDateTime
   *
   * Если преобразовать не удалось, возвращает null
   *
   * @param                   $value
   * @param null|string $format
   * @param DateTimeZone|null $timezone
   * @return MtDateTime|null
   * @throws Exception
   */
  public static function fromValue($value, ?string $format = null, DateTimeZone $timezone = null): ?MtDateTime
  {
    //can not parse date by that format
    if(!$value)
    {
      return null;
    }

    if($value instanceof MtDateTime)
    {
      return $value;
    }

    $key = (string)$value . $format;

    if(isset(self::$from_value_cache[$key]))
    {
      return self::$from_value_cache[$key];
    }

    if(!$timezone)
    {
      $timezone = self::getDefaultTimezone();
    }

    if($format)
    {
      $value = date_create_from_format($format, $value, $timezone);

      //can not parse date by that format
      if(!$value)
      {
        return null;
      }
    }

    if(!$value instanceof MtDateTime)
    {
      $value = new MtDateTime($value, $timezone);
    }

    self::$from_value_cache[$key] = $value;

    return $value;
  }

  /**
   * if there is value, tries to convert it to MtDateTime. if there is no value - current datetime returned
   *
   * @param $value
   * @return \DateTime|false|MtDateTime
   * @throws Exception
   */
  public static function fromValueDefaultNow($value): MtDateTime
  {
    if($value instanceof MtDateTime)
    {
      return $value;
    } //nothing to transform

    if(!$value)
    {
      return MtDateTime::now();
    }

    return static::fromValue($value);
  }


  private static $now = -1;

  /**
   * Current date and time (without microseconds)
   *
   * cached
   *
   * @return MtDateTime
   * @throws Exception
   */
  public static function now(): MtDateTime
  {
    if(self::$now === -1)
    {
      $tmp_datetime = new MtDateTime();

      self::$now = new MtDateTime($tmp_datetime->format(self::MYSQL_DATETIME));
    }

    return self::$now;
  }

  private static $default_timezone = -1;

  public static function getDefaultTimezone()
  {
    if(self::$default_timezone === -1)
    {
      $time_zone = 'Europe/Minsk';

      self::$default_timezone = new \DateTimeZone($time_zone);
    }

    return self::$default_timezone;
  }

  private static $month_names = array(
    1 => 'январь',
    2 => 'февраль',
    3 => 'март',
    4 => 'апрель',
    5 => 'май',
    6 => 'июнь',
    7 => 'июль',
    8 => 'август',
    9 => 'сентябрь',
    10 => 'октябрь',
    11 => 'ноябрь',
    12 => 'декабрь',
  );

  /**
   * @return string[]
   */
  public static function MonthNamesList(): array
  {
    return self::$month_names;
  }

  private static $week_day_names = array(
    1 => 'понедельник',
    2 => 'вторник',
    3 => 'среда',
    4 => 'четверг',
    5 => 'пятница',
    6 => 'суббота',
    7 => 'воскресенье',
  );

  /**
   * @return string[]
   */
  public static function WeekDayNamesList(): array
  {
    return self::$week_day_names;
  }

  private static $week_day_shortnames = array(
    1 => 'пн',
    2 => 'вт',
    3 => 'ср',
    4 => 'чт',
    5 => 'пт',
    6 => 'сб',
    7 => 'вс',
  );

  /**
   * @return string[]
   */
  public static function WeekDayShortNamesList(): array
  {
    return self::$week_day_shortnames;
  }

  private static $min_date = null;

  public static function minDate(): MtDateTime
  {
    if(!self::$min_date)
    {
      self::$min_date = new MtDateTime('0001-01-01 00:00:00');
    }

    return self::$min_date;
  }

  private static $max_date = null;

  public static function maxDate(): MtDateTime
  {
    if(!self::$max_date)
    {
      self::$max_date = new MtDateTime('9999-12-12 23:59:59');
    }

    return self::$max_date;
  }

  private $short_date = -1;

  public function getShortDate(): string
  {
    if($this->short_date === -1)
    {
      $this->short_date = $this->format(MtDateTime::SHORT_DATE);
    }

    return $this->short_date;
  }

  private $full_time = -1;

  public function getFullTime(): string
  {
    if($this->full_time === -1)
    {
      $this->full_time = $this->format(MtDateTime::FULL_TIME);
    }

    return $this->full_time;
  }

  private $short_time = -1;

  public function getShortTime(): string
  {
    if($this->short_time === -1)
    {
      $this->short_time = $this->format(MtDateTime::SHORT_TIME);
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
      $this->mysql_date = $this->format(MtDateTime::MYSQL_DATE);
    }

    return $this->mysql_date;
  }

  private $mysql_datetime = -1;

  public function getMysqlDateTime(): string
  {
    if($this->mysql_datetime === -1)
    {
      $this->mysql_datetime = $this->format(MtDateTime::MYSQL_DATETIME);
    }

    return $this->mysql_datetime;
  }

  private $xml_datetime = -1;

  public function getXmlDateTime(): string
  {
    if($this->xml_datetime === -1)
    {
      $this->xml_datetime = $this->format(MtDateTime::ISO8601);
    }

    return $this->xml_datetime;
  }

  private $xml2018_datetime = -1;

  public function getXml2018DateTime(): string
  {
    if($this->xml2018_datetime === -1)
    {
      $this->xml2018_datetime = $this->format('c');
    } //ISO 8601

    return $this->xml2018_datetime;
  }

  public function getWeekDayName(): string
  {
    return self::$week_day_names[$this->format('N')] ?? '[unknown]';
  }

  public function getWeekDayShortName(): string
  {
    return self::$week_day_shortnames[$this->format('N')] ?? '[unk]';
  }

  public function getMonthName(): string
  {
    return self::$month_names[$this->format('n')] ?? '[unknown]';
  }

  public function GetMonthYear(): string
  {
    return $this->getMonthName() . ' ' . $this->format('Y');
  }

  /**
   * Begin of day
   *
   * @return MtDateTime
   * @throws Exception
   */
  public function BeginOfDay(): MtDateTime
  {
    $bod = new MtDateTime($this->getMysqlDate());
    return $bod->setTime(0, 0);
  }

  /**
   * First day of month
   *
   * @return MtDateTime
   * @throws Exception
   */
  public function BeginOfMonth(): MtDateTime
  {
    $bom = new MtDateTime($this->format('Y-m') . '-01');

    return $bom;
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public static function BeginOfThisMonth(): MtDateTime
  {
    return (new self('first day of this month'))->BeginOfDay();
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public static function BeginOfPreviousMonth(): MtDateTime
  {
    return (new self('first day of previous month'))->BeginOfDay();
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public function BeginOfWeek(): MtDateTime
  {
    return $this->AddDays(-$this->format('N') + 1)->BeginOfDay();
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public function EndOfWeek(): MtDateTime
  {
    return $this->AddDays(7 - $this->format('N'))->EndOfDay();
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public static function BeginOfThisWeek(): MtDateTime
  {
    return self::now()->BeginOfWeek();
  }

  /**
   * @return MtDateTime
   * @throws Exception
   */
  public static function BeginOfPreviousWeek(): MtDateTime
  {
    return self::BeginOfThisWeek()->AddDays(-7);
  }

  public static function BeginOfNextMonth(): MtDateTime
  {
    return (new self('first day of next month'))->BeginOfDay();
  }

  /**
   * New date object with "23:59:59" value set as time
   *
   * @return MtDateTime
   * @throws Exception
   */
  public function EndOfDay(): MtDateTime
  {
    $eod = $this->BeginOfDay();
    return $eod->setTime(23, 59, 59);
  }

  public static function EndOfThisMonth(): MtDateTime
  {
    return (new self('last day of this month'))->EndOfDay();
  }

  public static function EndOfPreviousMonth(): MtDateTime
  {
    return (new self('last day of previous month'))->EndOfDay();
  }

  /**
   * Returns next second time. You can pass $number_of_seconds if you need to add (or subtract!) another number of seconds.
   *
   * @param int $number_of_seconds
   * @return MtDateTime
   * @throws Exception
   */
  public function NextSecond(int $number_of_seconds = 1): MtDateTime
  {
    $new_date = clone $this;

    if(!$number_of_seconds)
    {
      return $new_date;
    }

    $str = ($number_of_seconds >= 0 ? '+' : '') . $number_of_seconds . ' seconds';

    return new self($new_date->modify($str));
  }

  public function AddDays(int $number_of_days = 1): MtDateTime
  {
    $new_date = clone $this;

    if(!$number_of_days)
    {
      return $new_date;
    }

    $str = ($number_of_days >= 0 ? '+' : '') . $number_of_days . ' days';

    return new self($new_date->modify($str));
  }

  public function AddMonths(int $number_of_months = 1): MtDateTime
  {
    $str = ($number_of_months >= 0 ? '+' : '') . $number_of_months . ' month';

    $new_date = clone $this;
    if($new_date->modify($str) === false)
    {
      dd('$new_date->modify error');
    }

    if($new_date->format('j') != $this->format('j')) //we exceeded month limits
    {
      $new_date->modify('last day of last month');
    }

    return new self($new_date);
  }

  public function AddYears(int $number_of_years = 1): MtDateTime
  {
    $str = ($number_of_years >= 0 ? '+' : '') . $number_of_years . ' years';

    $new_date = clone $this;
    return new self($new_date->modify($str));
  }

  public function equals(?MtDateTime $datetime, $date_only = false): bool
  {
    if(!$datetime)
    {
      return false;
    }

    if($date_only)
    {
      return $this->getMysqlDate() == $datetime->getMysqlDate();
    }
    else
    {
      return $this->getMysqlDateTime() == $datetime->getMysqlDateTime();
    }
  }

  /**
   * Returns true if $this date fits into interval between $start and $end.
   * $start and $end can be omitted.
   *
   * @param MtDateTime|null $start
   * @param MtDateTime|null $end
   * @param bool $date_only check date only, no time part checked
   * @return bool
   */
  public function fits(?MtDateTime $start, ?MtDateTime $end, $date_only = true): bool
  {
    $d = $date_only ? $this->getMysqlDate() : $this->getMysqlDateTime();

    $start_d = $start ?: self::minDate();
    $start_d = $date_only ? $start_d->getMysqlDate() : $start_d->getMysqlDateTime();

    $end_d = $end ?: self::maxDate();
    $end_d = $date_only ? $end_d->getMysqlDate() : $end_d->getMysqlDateTime();

    return $d >= $start_d && $d <= $end_d;
  }

  public function isBefore(MtDateTime $datetime, bool $allow_equal = false): bool
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

  public function isAfter(MtDateTime $datetime, bool $allow_equal = false): bool
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

  /**
   * Comparing dates (like strcmp)
   * @param MtDateTime|null $a
   * @param MtDateTime|null $b
   * @return int -1, 0, or +1
   */
  public static function compare(?MtDateTime $a, ?MtDateTime $b): int
  {
    if(!$a && !$b)
    {
      return 0;
    }

    if(!$a && $b)
    {
      return -1;
    }

    if($a && !$b)
    {
      return 1;
    }

    if($a->equals($b))
    {
      return 0;
    }
    elseif($a->isBefore($b))
    {
      return -1;
    }
    else
    {
      return 1;
    }
  }

  /**
   * full number of days between current date and $to_date
   *
   * @param $to_date
   * @return int
   * @throws Exception
   */
  public function GetDaysInterval($to_date): int
  {
    $to_date = MtDateTime::fromValue($to_date);

    return $this->diff($to_date, true)->days + 1;
  }
}