<?php


namespace App\Http\Controllers;


use App\Models\MrLanguage;
use App\Models\MrPolicy;

class MrPolicyController extends Controller
{
  public function View()
  {
    $out = array();
    $locate = app()->getLocale();
    $language = MrLanguage::loadBy($locate, 'Name');

    $policy = MrPolicy::loadBy($language->id(), 'LanguageID');

    if(!$policy)
    {
      $policy = MrPolicy::loadBy('ru', 'LanguageID');
    }

    $out['policy'] = $policy;

    return View('policy')->with($out);
  }
}