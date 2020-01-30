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
      'Наименование',
      'English',
      'Код 1',
      'Код 2',
      '#',
    );

    $rows = array();
    foreach ($list['items'] as $item)
    {
      $row = array();
      /** @var MrCountry $item */
      $row[] = $item->id();
      $row[] = $item->getNameEng();
      $row[] = $item->getNameRus();
      $row[] = $item->getCode();
      $row[] = $item->getNumericCode();

      $edit = MrForm::loadForm(
        'admin_reference_country_form_edit',
        'Admin\\MrAdminReferenceCurrencyEditForm',
        ['id' => $item->id()],
        '', ['btn btn-primary btn-xs fa fa-edit']
      );

      $delete = MrLink::open(
        'reference_item_delete', ['name' => 'country', 'id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash-alt'
      );

      $row[] = array($edit, $delete);

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}