<?php


namespace App\Http\Controllers;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Http\Controllers\TableControllers\References\MrReferencesCountryTableController;
use App\Http\Controllers\TableControllers\References\MrReferencesCurrencyTableController;
use App\Http\Controllers\TableControllers\References\MrReferencesMeasureTableController;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrReferencesController extends Controller
{
  protected $references = array(
    'country'  => 'Страны мира',
    'currency' => 'Валюты мира',
    'measure'  => 'Классификатор единиц измерения',
  );

  public function ListCountries()
  {
    return MrTableController::buildTable(MrReferencesCountryTableController::class);
  }

  public function ListCurrency()
  {
    return MrTableController::buildTable(MrReferencesCurrencyTableController::class);
  }

  public function ListMeasure()
  {
    return MrTableController::buildTable(MrReferencesMeasureTableController::class);
  }

  /**
   * Публичная страница справочника
   *
   * @param string $name
   * @return Factory|View
   */
  public function View(string $name)
  {
    $out = array();

    if(isset($this->references[$name]) && ($reference = $this->references[$name]))
    {
      $out['page_title'] = __('mr-t.' . $reference);

      // Загрузка модели
      $pref = 'Mr';
      $class_name = "App\\Models\\References\\" . $pref . ucfirst($name);
      if(class_exists($class_name))
      {
        $out['route_name'] = $class_name::getRouteTable();

        return View('References.reference')->with($out);
      }
    }

    abort('404', __('mr-t.Справочник не найден'));
  }
}