<?php


namespace App\Http\Controllers\TableControllers;


use App\Forms\FormBase\MrForm;
use App\Forms\FormBase\MrLink;
use App\Models\MrTariffInOffice;

class MrOfficeTariffTableController extends MrTableController
{
  public static function buildTable($list)
  {
    $header = array(
      'Тариф', 'Дата добавления'
    );

    $rows = array();
    foreach ($list as $item)
    {
      $row = array();
      /** @var MrTariffInOffice $item */
      $row[] = $item->getTariff()->getName();
      $row[] = $item->getWriteDate() ? $item->getWriteDate()->getShortDate() : null;

      if($item->canEdit())
      {
        $edit = MrForm::loadForm('office_tariffs_edit', ['id' => $item->id()], '', ['btn btn-primary btn-xs fa fa-edit'], 'xs');

        $delete = MrLink::open(
          'delete_tariff_from_office', ['office_id' => $item->getOffice()->id(), 'id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash'
        );
        $header['#'] = '#';
        $row[] = array($edit, $delete);
      }

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}