<?php


namespace App\Http\Controllers\Helpers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MrMessageHelper extends Controller
{

  const KIND_ERROR = 'alert-danger';
  const KIND_SUCCESS = 'alert-success';


  /**
   * Сообщение на страницу
   *
   * @param bool $kind
   * @param string $message
   */
  public static function SetMessage(bool $kind, string $message)
  {
    if($kind)
    {
      $kind = self::KIND_SUCCESS;
    }
    else
    {
      $kind = self::KIND_ERROR;
    }

    Session::flash($kind, $message);
  }

  /**
   * Сообщение на страницу
   *
   * @return string
   */
  public static function GetMessage(): string
  {
    $out = '';
    if(session(self::KIND_ERROR))
    {
      $out = '<div class="alert ' . self::KIND_ERROR . '" role="alert"><span class="badge badge-pill badge-danger"> Error</span>' . Session(self::KIND_ERROR) . "</div>";
    }
    elseif(session(self::KIND_SUCCESS))
    {
      $out = '<div class="alert ' . self::KIND_SUCCESS . '" role="alert"><span class="badge badge-pill badge-success"> Success</span> ' . Session(self::KIND_SUCCESS) . "</div>";
    }

    return $out;
  }
}