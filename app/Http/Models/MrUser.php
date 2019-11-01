<?php

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrUser extends ORM
{
  private $admin_email = 'allximik50@gmail.com';
  private $zero_email = 'mega-ximik@mail.ru';
  protected static $className = MrUser::class;
  protected static $mr_caches = array('emails');

  protected static $mr_table = 'mr_users';
  protected static $dbFieldsMap = array(
    'UserLaravelID',
    'DateFirstVisit',
    'DateLogin',
    'DateLastVisit',
    'Phone',
  );

  public static function loadBy($value, $field = 'id'): ?MrUser
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  public function deleteAll()
  {
    DB::table('users')->WHERE('id', '=', $this->getUserLaravel())->delete();

    $this->mr_delete();
  }

  /**
   * Проверяет, авторизован-ли пользователь
   *
   * @return MrUser|null
   */
  public static function me(): ?MrUser
  {
    if(Auth::check())
    {
      return MrUser::loadBy(Auth::id(), 'UserLaravelID');
    }
    else
    {
      return null;
    }
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
  public function getDateFirstVisit(): Carbon
  {
    return new Carbon($this->DateFirstVisit);
  }


  public function setDateFirstVisit(Carbon $value)
  {
    $this->DateFirstVisit = $value;
  }

  // Дата залогинивания
  public function getDateLogin(): ?Carbon
  {
    return $this->DateLogin ? new Carbon($this->DateLogin) : null;
  }


  public function setDateLogin()
  {
    $this->DateLogin = Carbon::now();
  }

  // Дата последнего посещения
  public function getDateLastVisit(): ?Carbon
  {
    return $this->DateLastVisit ? new Carbon($this->DateLastVisit) : null;
  }

  public function setDateLastVisit(Carbon $value)
  {
    $this->DateLastVisit = $value;
  }
  //////////////////////////////////////////////////////////////////////////////////

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
   * @return MrUsersBloked|null
   */
  public function getBlock(): ?MrUsersBloked
  {
    $list = MrUsersBloked::GetAllBlocked();
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
  public function IsAdmin(): bool
  {
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
    if($user = MrUser::me())
    {
      $user_laravel = $user->getUserLaravel();
      $user->mr_delete();

      User::find($user_laravel->id)->delete();
    }
  }

  /** ID пользователя-заглушки
   * @return MrUser|null
   */
  public static function zeroUser()
  {
    return self::loadBy(2);
  }

  public static function SelectList()
  {
    $out = array();
    foreach (self::GetAll() as $user)
    {
      $out[$user->id()] = $user->GetFullName();
    }
    return $out;
  }
}
