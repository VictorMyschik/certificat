<?php

namespace App\Http\Middleware;


use App\Models\MrBotUserAgent;
use App\Models\MrLogIdent;
use App\Models\MrUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class Allximik extends Middleware
{
  public function handle($request, Closure $next)
  {
    $this->saveMrLogIdent();

    return $next($request);
  }

  // Запись лога в mr_log_ident (общий лог)
  public function saveMrLogIdent()
  {
    $data = self::getHttpData();
    if($mr_user = MrUser::me())
    {
      $mr_user->setDateLastVisit(Carbon::now());
      $mr_user_id = $mr_user->save_mr();
    }

    $newIdent = new MrLogIdent();
    $newIdent->setIp($data['IP']);
    $newIdent->setLink($data['URL']);
    $newIdent->setReferer($data['Referer']);
    $newIdent->setUserID($mr_user_id ?? null);
    $newIdent->setBotID($data['Bot'] ? $data['Bot']->id() : null);
    $newIdent->setUserAgent($data['UserAgent']);
    $newIdent->setCity((string)$data['City']);
    $newIdent->setCountry((string)$data['Country']);
    $newIdent->setCookie($data['Cookie']);

    $id = $newIdent->save_mr();

    return $id;
  }

  public static function getHttpData(): ?array
  {
    $UserAget = (string)$_SERVER['HTTP_USER_AGENT'];
    $IP = (string)$_SERVER['REMOTE_ADDR'];
    $Referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    $URL = (string)$_SERVER['REQUEST_URI'];
    $UserLanguage = (string)$_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $Method = (string)$_SERVER['REQUEST_METHOD'];

    if(!empty($_COOKIE["id_user"]))
    {
      $Cookie = $_COOKIE['id_user'];
    }
    else
    {
      session_start();
      $Cookie = session_id();
      setcookie("id_user", $Cookie, time() + 31536000);
    }

    // бот из БД
    $bot = MrBotUserAgent::loadBy($UserAget, 'UserAgent');
    /////////////////////////////////////////////////////
    $client = $IP;
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
    else $ip = $IP;

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if($ip_data && $ip_data->geoplugin_city != null)
      $city_id = $ip_data->geoplugin_city;

    $out = array(
      'UserAgent' => $UserAget,
      'IP' => (string)$IP,
      'Referer' => substr($Referer,0,400),
      'URL' => $URL,
      'Bot' => $bot,
      'UserLanguage' => $UserLanguage,
      'UserMrCookie' => isset($user) ? $user->id() : null,
      'Method' => $Method,
      'City' => isset($city_id) ? $city_id : null,
      'Country' => isset($ip_data->geoplugin_countryName) ? (string)$ip_data->geoplugin_countryName : null,
      'Cookie' => $Cookie,
    );

    return $out;
  }
}
