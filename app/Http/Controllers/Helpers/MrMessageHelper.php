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
     * @param  string  $kind
     * @param  string  $message
     * @param  string  $name
     */
    public static function SetMessage(string $kind, string $message)
    {
        Session::flash($kind, $message);
    }

    /**
     * Сообщение на страницу
     *
     * @param  string  $name
     * @return string
     */
    public static function GetMessage(): string
    {
        $out = '';
        if (session(self::KIND_ERROR))
        {
            $out = '<div class="alert '.self::KIND_ERROR.'" role="alert">'.Session(self::KIND_ERROR)."</div>";
        }
        elseif(session(self::KIND_SUCCESS))
        {
            $out = '<div class="alert '.self::KIND_SUCCESS.'" role="alert"><span class="badge badge-pill badge-success ">Success</span> '.Session(self::KIND_SUCCESS)."</div>";
        }

        return $out;
    }
}