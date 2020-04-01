<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\MrTariff;

class MrAdminTariffController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Тарифные планы';

    $out['list'] = MrTariff::GetAll();

    return View('Admin.mir_admin_tariffs')->with($out);
  }

  public function tariffDelete(int $id)
  {
    $tariff = MrTariff::loadBy($id);

    if($tariff->canDelete())
    {
      $tariff->mr_delete();
      MrMessageHelper::SetMessage(true, 'Успешно удалено');
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Удаление нефозможно, есть офисы, подключенные на этот тариф');
    }
    return back();
  }
}