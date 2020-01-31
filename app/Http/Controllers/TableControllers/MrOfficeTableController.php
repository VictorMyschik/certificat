<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Forms\FormBase\MrLink;
use App\Http\Models\MrOffice;

class MrOfficeTableController extends MrTableController
{
  public static function buildTable($list)
  {
    $header = array(
      'ID', 'Наименование', 'Админ(ы)', 'Тарифы', 'Примечание', '#'
    );

    $rows = array();
    foreach ($list['items'] as $item)
    {
      $row = array();
      /** @var MrOffice $item */
      $row[] = $item->id();
      $row[] = $item->getName();
      $admins = '';
      foreach ($item->GetUsers() as $admin)
      {
        $admins .= '<div>'.$admin->getUser()->GetFullName().'</div>';
      }

      $row[] = $admins;

      $tariffs_out = '';
      foreach($item->GetTariffs() as $t)
      {
        $tariffs_out .= $t->getTariff()->GetFullName();
      }
      $row[] = $tariffs_out;
      $row[] = $item->getDescription();

      $open = MrLink::open(
        'admin_office_page', ['id' => $item->id()], '', 'btn btn-primary btn-xs fa fa-eye'
      );

      $row[] = array($open);

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $list);
  }
}