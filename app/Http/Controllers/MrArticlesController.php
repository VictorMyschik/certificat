<?php


namespace App\Http\Controllers;


use App\Http\Models\MrLanguage;
use App\Http\Models\MrPolicy;

class MrArticlesController extends Controller
{
  public function ViewPolicy()
  {
    $out = array();
    $locate = app()->getLocale();
    $language = MrLanguage::loadBy($locate, 'Name');

    $policy = MrArticles::loadBy($language->id(), 'LanguageID');

    if(!$policy)
    {
      $policy = MrPolicy::loadBy('ru', 'LanguageID');
    }

    $out['policy'] = $policy;

    return View('policy')->with($out);
  }
}