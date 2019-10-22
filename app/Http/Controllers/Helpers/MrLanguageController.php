<?php


namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\MrLanguage;
use App\Models\MrTranslate;

class MrLanguageController extends Controller
{
  protected static $words = array();

  public static function Translate(string $rus)
  {
    self::GetTranslatedWords();
    foreach (self::$words as $word)
    {
      if($word->getName() == $rus)
      {
        return $word->getTranslate();
      }
    }

    return $rus;
  }

  public static function GetTranslatedWords()
  {
    $r = $_SERVER['REQUEST_URI'];
    $lg_code = substr($r, 1, 2);

    $lg_code = mb_strtoupper($lg_code);
    if($lg = MrLanguage::loadBy($lg_code, 'Name'))
    {
      self::$words = MrTranslate::GetByLg($lg);
    }
  }

  public static function getLanguage()
  {
    $r = $_SERVER['REQUEST_URI'];
    $lg_code = substr($r, 1, 2);

    return mb_strtoupper($lg_code);
  }
}