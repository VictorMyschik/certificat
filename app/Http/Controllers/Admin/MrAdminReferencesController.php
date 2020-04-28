<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use App\Models\References\MrCurrency;
use App\Models\References\MrMeasure;
use App\Models\References\MrTechnicalReglament;
use App\Models\References\MrTechnicalRegulation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MrAdminReferencesController extends Controller
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

  public function ViewMeasure()
  {
    $out = array();
    $out['page_title'] = 'Классификатор единиц измерения';
    $out['route_name'] = MrMeasure::getRouteTable();

    return View('Admin.References.mir_admin_reference_measure')->with($out);
  }

  public function ViewCertificateKind()
  {
    $out = array();
    $out['page_title'] = 'Классификатор видов документов об оценке соответствия';
    $out['route_name'] = MrCertificateKind::getRouteTable();

    return View('Admin.References.mir_admin_reference_certificate_kind')->with($out);
  }

  public function ViewTechnicalRegulation()
  {
    $out = array();
    $out['page_title'] = 'Классификатор видов объектов технического регулирования';
    $out['route_name'] = MrTechnicalRegulation::getRouteTable();

    return View('Admin.References.mir_admin_reference_technical_regulation')->with($out);
  }

  public function ViewTechnicalReglament()
  {
    $out = array();
    $out['page_title'] = 'Принятые технические регламенты';
    $out['route_name'] = MrTechnicalReglament::getRouteTable();

    return View('Admin.References.mir_admin_reference_technical_reglament')->with($out);
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
}