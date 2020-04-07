<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\MrAddressesTableController;
use App\Models\MrAddresses;
use App\Models\References\MrCountry;
use App\Models\References\MrCurrency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MrAdminReferences extends Controller
{
  /**
   * Загрузка одного справочника
   * @return Factory|View
   */
  public function ViewCountry()
  {
    $out = array();
    $out['page_title'] = 'Справочник стран мира';
    $out['route_name'] = MrCountry::getRouteTable();

    return View('Admin.References.mir_admin_reference_country')->with($out);
  }

  public function ViewCurrency()
  {
    $out = array();
    $out['page_title'] = 'Справочник валют';
    $out['route_name'] = MrCurrency::getRouteTable();

    return View('Admin.References.mir_admin_reference_currency')->with($out);
  }

  /**
   * Переустановка справочника
   * @return RedirectResponse
   */
  public function RebuildCountry()
  {
    MrCountry::AllDelete();
    MrCountry::RebuildReference();

    return back();
  }

  /**
   * Удаление строки из справочника по ID
   *
   * @param string $reference
   * @param int $id
   * @return RedirectResponse
   */
  public function DeleteForID(string $reference, int $id)
  {
    $pref = 'Mr';
    $l = substr($reference, 0, 1);

    $class_name = substr_replace($reference, mb_strtoupper($l), 0, 1);

    $class_name = "App\\Models\\References\\" . $pref . $class_name;

    /** @var object $class_name */
    $row = $class_name::loadBy($id);
    $row->mr_delete();

    return back();
  }

  /**
   * Справочник городов в стране
   *
   * @param int $id
   * @return Factory|View
   */
  public function ViewAddresses($id = 1)
  {
    $country = MrCountry::loadBy($id);

    $out = array();
    $out['page_title'] = 'Справочник адресов';

    $out['table'] = MrAddressesTableController::buildTable($country->GetAddresses());
    $out['country'] = $country;
    return View('Admin.mir_admin_addresses')->with($out);
  }

  public function AddressDelete(int $id)
  {
    $address = MrAddresses::loadBy($id);

    if(!$address->canView())
    {
      mr_access_violation();
    }

    $address->mr_delete();


    return back();
  }
}