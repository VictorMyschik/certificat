<?php


namespace App\Http\Controllers\TableControllers;


use App\Forms\FormBase\MrForm;
use App\Forms\FormBase\MrLink;
use App\Models\MrDiscount;

class MrDiscountTableController extends MrTableController
{
  public static function buildTable($list, bool $admin = false)
  {
    $header = array(
      'Тариф', 'Дата с', 'Дата по', 'Размер'
    );

    $rows = array();
    foreach ($list as $item)
    {
      $row = array();
      /** @var MrDiscount $item */
      $row[] = $item->id();
      $row[] = $item->getDateFrom() ? $item->getDateFrom()->getShortDate() : null;
      $row[] = $item->getDateTo() ? $item->getDateTo()->getShortDate() : null;
      $row[] = $item->getAmount();

      if($admin)
      {
        $edit = MrForm::loadForm('office_discount_edit', 'MrAdminOfficeDiscountEditForm', ['office_id' => $item->getOffice()->id(), 'id' => $item->id()], '', ['btn btn-primary btn-xs fa fa-edit'], 'xs');

        $delete = MrLink::open(
          'discount_delete', ['id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash'
        );
        $header['#'] = '#';
        $row[] = array($edit, $delete);
      }

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}