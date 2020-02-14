<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Forms\FormBase\MrForm;
use App\Http\Controllers\Forms\FormBase\MrLink;
use App\Http\Models\MrCountry;

class MrCountryTableController extends MrTableController
{
  public static function buildTable($list)
  {
    $header = array(
      'ID',
      'Континент',
      'Наименование',
      'Столица',
      'ISO-3166 alpha2',
      'ISO-3166 alpha3',
      'ISO-3166 numeric',
      '#',
    );

    $rows = array();
    foreach ($list['items'] as $item)
    {
      $row = array();
      /** @var MrCountry $item */
      $row[] = $item->id();
      $row[] = $item->getContinentName();
      $row[] = $item->getName();
      $row[] = $item->getCapital();
      $row[] = $item->getISO3166alpha2();
      $row[] = $item->getISO3166alpha3();
      $row[] = $item->getISO3166numeric();

      $edit = MrForm::loadForm(
        'admin_reference_country_form_edit',
        ['id' => $item->id()],
        '', ['btn btn-primary btn-xs fa fa-edit'],'sm'
      );

      $delete = MrLink::open(
        'reference_item_delete', ['name' => 'country', 'id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash'
      );

      $open = MrLink::open(
        'admin_reference_country_cities_page', ['id' => $item->id()], '', 'btn btn-success btn-xs fa fa-eye'
      );

      $row[] = array($open, $edit, $delete);

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}