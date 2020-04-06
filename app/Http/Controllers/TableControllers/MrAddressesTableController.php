<?php


namespace App\Http\Controllers\TableControllers;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Models\MrAddresses;

class MrAddressesTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $header = array(

    );

    $rows = array();
    foreach ($list as $item)
    {
      $row = array();
      /** @var MrAddresses $item */


      $edit = MrForm::loadForm('admin_address_form_edit', ['id' => $item->id()], '', ['btn btn-primary btn-xs fa fa-edit'], 'xs');

      $delete = MrLink::open(
        'address_delete', ['id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash'
      );

      // гугл карты
      $open = MrForm::loadForm('address_map_popup_edit', ['id' => $item->id()], '', ['btn btn-success btn-xs fa fa-map']);

      $row[] = array($open, $edit, $delete);

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}