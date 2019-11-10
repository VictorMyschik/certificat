<?php


namespace App\Http\Controllers;


use App\Http\Models\MrCertificate;
use App\Http\Models\MrLanguage;
use App\Http\Models\MrPolicy;
use App\Http\Models\MrUser;
use Illuminate\Http\Request;

class MrApiController extends Controller
{
  public function ViewApi()
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

  /**
   * Живой поиск
   *
   * @param Request $request
   * @return array
   */
  public function search(Request $request): array
  {
    $out = array();
    $list = MrCertificate::Search($request->get('search', null));

    if(count($list) == 1)
    {
      MrCertificate::SetCacheSearch($list[0], MrUser::me());
    }

    foreach ($list as $item)
    {
      $out[$item->getNumber()] = $item->GetFullName();
    }


    return $out;
  }
}