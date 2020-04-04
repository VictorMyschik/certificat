<?php

namespace App\Models;


use App\Helpers\MrCacheHelper;
use App\Helpers\MrDateTime;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrUser extends ORM
{
  private $admin_email = 'allximik50@gmail.com';
  protected static $className = MrUser::class;
  public static $mr_table = 'mr_user';

  protected static $dbFieldsMap = array(
    'UserLaravelID',
    'Telegram',
    'DateFirstVisit',
    'DateLogin',
    'DateLastVisit',
    'Phone',
    'DefaultOfficeID'
  );

  public static function loadBy($value, $field = 'id'): ?MrUser
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canEdit()
  {
    $me = self::me();
    if($me->id() == $this->id() || $me->IsSuperAdmin())
    {
      return true;
    }

    return false;
  }

  protected function before_delete()
  {
    $subscription = MrSubscription::loadBy($this->getEmail(), 'Email');
    $subscription ? $subscription->mr_delete() : null;

    $uio = MrUserInOffice::loadBy($this->id(), 'UserID');

    foreach (MrCertificateMonitoring::GetByUserInOffice($uio) as $item)
    {
      $item->mr_delete();
    }

    MrCertificateMonitoring::loadBy($uio->id(), 'UserInOfficeID');

    $uio->mr_delete();
  }


  private static $me = null;

  /**
   * Проверяет, авторизован ли пользователь
   *
   * @return MrUser|null
   */
  public static function me(): ?MrUser
  {
    if($me = self::$me)
    {
      return $me;
    }
    else
    {
      if(Auth::check())
      {
        $me = MrUser::loadBy(Auth::id(), 'UserLaravelID');

        return $me;
      }
      else
      {
        return null;
      }
    }
  }

  public function getDateVerify(): ?MrDateTime
  {
    $date = null;
    $date = $this->getUserLaravel()->getEmailVerifiedDate();

    return $date;
  }

  // пользователь Laravel
  public function getUserLaravel(): ?User
  {
    if($this['UserLaravelID'])
    {
      $object = User::where('id', $this['UserLaravelID'])->get();
    }
    else
    {
      return null;
    }

    if(!count($object))
    {
      return null;
    }

    $object = $object[0];

    return $object;
  }

  public function setUserLaravelID(int $value)
  {
    $this->UserLaravelID = $value;
  }

  // Login
  public function getName(): ?string
  {
    return $this->getUserLaravel() ? $this->getUserLaravel()->getName() : null;
  }

  // Telegram
  public function getTelegram(): ?string
  {
    return $this->Telegram;
  }

  public function setTelegram(?string $value)
  {
    $this->Telegram = $value;
  }

  // Эл. почта
  public function getEmail(): ?string
  {
    return $this->getUserLaravel() ? $this->getUserLaravel()->getEmail() : null;
  }

  // Эл. почта
  public function getPhone(): ?string
  {
    return $this->Phone;
  }

  public function setPhone(?string $value)
  {
    $this->Phone = $value;
  }

  // Дата первого посещения
  public function getDateFirstVisit(): MrDateTime
  {
    return $this->getDateNullableField('DateFirstVisit');
  }


  public function setDateFirstVisit($value)
  {
    $this->setDateNullableField($value, 'DateFirstVisit');
  }

  // Дата залогинивания
  public function getDateLogin(): ?MrDateTime
  {
    return $this->getDateNullableField('DateLogin');
  }

  public function setDateLogin()
  {
    $this->setDateNullableField(MrDateTime::now(), 'DateLogin');
  }

  // Дата последнего посещения
  public function getDateLastVisit(): ?MrDateTime
  {
    return $this->getDateNullableField('DateLastVisit');
  }

  public function setDateLastVisit($value)
  {
    $this->setDateNullableField($value, 'DateLastVisit');
  }

  public function getDefaultOffice(): ?MrOffice
  {
    return MrOffice::loadBy($this->DefaultOfficeID);
  }

  public function setDefaultOfficeID(?int $value)
  {
    $this->DefaultOfficeID = $value;
  }

  //////////////////////////////////////////////////////////////////////////////////

  public function getLogIdent()
  {
    return MrLogIdent::loadBy(MrLogIdent::$ident_id);
  }

  /**
   * Подписка на обновления
   *
   * @return bool
   */
  public function getIsSubscription(): bool
  {
    $sub = MrSubscription::loadBy($this->getEmail(), 'Email');
    if($sub)
    {
      return true;
    }
    else
    {
      return false;
    }
  }


  /**
   * Блокировка аккаунта
   *
   * @return MrUserBlocked|null
   */
  public function getBlock(): ?MrUserBlocked
  {
    $list = MrUserBlocked::GetAllBlocked();
    foreach ($list as $item)
    {
      if($this->id == $item->getUser()->id())
      {
        return $item;
      }
    }

    return null;
  }

  /**
   * Список всех поьзователей
   *
   * @return self[]
   */
  public static function GetAll(): array
  {
    $list = DB::table(static::$mr_table)->get(['id']);
    $out = array();
    foreach ($list as $id)
    {
      if($user = parent::loadBy((string)$id->id))
      {
        $out[] = $user;
      }
    }

    return $out;
  }

  /**
   * Последняя страница на которой был неавторизованный пользователь
   * Нужно для редиректа после авторизации на предыдущую страницу
   *
   * @return string
   */
  public function getPreviousUrl(): string
  {
    $log_authed = MrLogIdent::loadBy($this->id(), 'UserID');
    $links = DB::table(MrLogIdent::$mr_table)
      ->WHERE('Cookie', '=', $log_authed->getCookie())
      ->whereNull('UserID')
      ->orderBy('Date', 'desc')
      ->limit(200)
      ->pluck('Link')->toArray();

    $url = '';
    foreach ($links as $link)
    {
      if($link == '/ulogin' || $link == '/login' || $link == '/home' || $link == '/register')
      {
        continue;
      }
      $url = $link;
      break;
    }

    return $url;
  }

  /**
   * Админ или нет
   *
   * @return bool
   */
  public function IsSuperAdmin(): bool
  {
    if(!Auth::check())
    {
      return false;
    }

    $admins = array(
      $this->admin_email,
      'valuxin@live.com',
    );

    return in_array($this->getEmail(), $admins);
  }

  public function GetFullName()
  {
    $r = '';
    $r .= $this->getName();
    $r .= ' (';
    $r .= $this->getEmail() . ')';


    return $r;
  }

  /**
   * Список всех Email-ов БД
   * @return array
   */
  public static function GetEmailList(): array
  {
    return Cache::rememberForever('emails', function () {
      $list = DB::table('users')->pluck('email')->toArray();
      $out = array();
      foreach ($list as $item)
      {
        $out[] = $item;
      }
      return $out;
    });
  }

  /**
   * Удаление аккаунта
   */
  public function AccountDelete()
  {
    $user_laravel = $this->getUserLaravel();
    $this->mr_delete();

    User::find($user_laravel->id)->delete();
  }

  /** ID пользователя-заглушки
   * @return MrUser|null
   */
  public static function zeroUser()
  {
    return self::loadBy(2);
  }

  /**
   * @return MrOffice[]
   */
  public function GetUserOffices(): array
  {
    return MrCacheHelper::GetCachedObjectList('user_offices' . '|' . $this->id(), MrOffice::$className, function () {
      return DB::table(MrOffice::$mr_table)
        ->leftJoin(MrUserInOffice::$mr_table, MrUserInOffice::$mr_table . '.OfficeID', '=', MrOffice::$mr_table . '.id')
        ->where(MrUserInOffice::$mr_table . '.UserID', $this->id())
        ->pluck(MrOffice::$mr_table . '.id')->toArray();
    });
  }

  /**
   * Загрузка пользователя по Email
   *
   * @param string $email
   * @return MrUser|null
   */
  public static function LoadUserByEmail(string $email): ?MrUser
  {
    $user = DB::table('users')->where('email', $email)->first(['id']);
    return MrUser::loadBy($user->id ?? null, 'UserLaravelID');
  }


}