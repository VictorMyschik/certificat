<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\MrOfficeTableController;
use App\Http\Controllers\TableControllers\MrUserInOfficeTableController;
use App\Models\MrDiscount;
use App\Models\MrOffice;
use App\Models\MrTariffInOffice;
use App\Models\MrUserInOffice;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrAdminOfficeController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Виртуальные офисы';
    $out['list'] = MrOffice::GetAll();

    $list = MrOffice::GetAllPaginate(10);
    $out['table'] = MrOfficeTableController::buildTable($list);
    return View('Admin.mir_admin_office')->with($out);
  }

  /**
   * Страница ВО
   *
   * @param int $id
   * @return Factory|View
   */
  public function OfficePage(int $id)
  {
    $out = array();
    $office = MrOffice::loadBy($id);

    $title = $office->getName();

    $out['page_title'] = $title;
    $out['office'] = $office;


    $out['user_in_office'] = MrUserInOfficeTableController::buildTable($office->GetUsers(), $office->GetNewUsers(), $office);
    return View('Admin.mir_admin_office_page')->with($out);
  }

  public function officeDelete(int $id)
  {
    $office = MrOffice::loadBy($id);
    if(!$office)
    {
      MrMessageHelper::SetMessage(false, 'Офис не найден');
      return back();
    }

    if($office->canDelete())
    {
      $office->mr_delete();
      MrMessageHelper::SetMessage(true, 'Офис удалён');
      return back();
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Офис не найден');
      return back();
    }
  }

  public function tariffOfficeDelete(int $id)
  {
    $tariff_office = MrTariffInOffice::loadBy($id);
    $tariff_office->mr_delete();
    MrMessageHelper::SetMessage(true, 'Тариф удалён из ВО');

    return back();
  }

  public function userOfficeDelete(int $id)
  {
    $tariff_office = MrUserInOffice::loadBy($id);
    $tariff_office->mr_delete();
    MrMessageHelper::SetMessage(true, 'Пользователь удалён из ВО');

    return back();
  }

  public function discountDelete(int $id)
  {
    $discount = MrDiscount::loadBy($id);
    $discount->mr_delete();

    MrMessageHelper::SetMessage(true, 'Скидка из ВО удалена');
    return back();
  }
}