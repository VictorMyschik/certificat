<?php


namespace App\Http\Controllers\TableControllers;


use App\Forms\FormBase\MrForm;
use App\Forms\FormBase\MrLink;
use App\Models\MrCurrency;

class MrCurrencyTableController extends MrTableController
{
  public static function buildTable($list)
  {
    $header = array(
      'ID', 'Код 1', 'Код 2', 'Наименование', 'Дата с', 'Дата по', 'Округление', 'Примечание', '#'
    );

    $rows = array();
    foreach ($list['items'] as $item)
    {
      $row = array();
      /** @var MrCurrency $item */
      $row[] = $item->id();
      $row[] = $item->getCode();
      $row[] = $item->getTextCode();
      $row[] = $item->getName();
      $row[] = $item->getDateFrom() ? $item->getDateFrom()->getShortDate() : null;
      $row[] = $item->getDateTo() ? $item->getDateTo()->getShortDate() : null;
      $row[] = $item->getRounding();
      $row[] = $item->getDescription();

      $edit = MrForm::loadForm('admin_reference_currency_form_edit', ['id' => $item->id()], '', ['btn btn-primary btn-xs fa fa-edit']
      );

      $delete = MrLink::open(
        'reference_item_delete', ['name' => 'currency', 'id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash'
      );

      $row[] = array($edit, $delete);

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}