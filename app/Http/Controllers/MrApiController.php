<?php


namespace App\Http\Controllers;


use App\Http\Models\MrLanguage;
use App\Http\Models\MrPolicy;

class MrApiController extends Controller
{
  public function View()
  {
    $out = array();

    $locate = app()->getLocale();
    $language = MrLanguage::loadBy($locate, 'Name');

    $policy = MrApi::loadBy($language->id(), 'LanguageID');

    if(!$policy)
    {
      $policy = MrPolicy::loadBy('ru', 'LanguageID');
    }

    $out['policy'] = $policy;

    return View('api')->with($out);
  }

}