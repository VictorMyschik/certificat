<?php


namespace App\Http\Controllers;


use App\Http\Models\MrCertificate;
use App\Http\Models\MrUser;
use Illuminate\Http\Request;

class MrApiController extends Controller
{
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

  /**
   * Получение данных от телеграм
   * @param Request $request
   * @return null
   */
  public function TelegramWebHook(Request $request)
  {

    return null;
  }
}
