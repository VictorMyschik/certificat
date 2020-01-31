<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Forms\FormBase\MrLink;
use App\Http\Models\MrUserInOffice;

class MrUserInOfficeTableController extends MrTableController
{
  public static function buildTable(array $has_users, array $new_users)
  {
    $header = array(
      __('mr-t.Пользователь'), __('mr-t.Привилегии'), '#'
    );

    $rows = array();

    foreach ($new_users as $new_user)
    {
      $row = array();
      /** @var MrUserInOffice $item */
      $row[] = $new_user->getUser()->GetFullName();

      // привилегии приглашённого пользователя
      $privileges = $new_user->getIsAdmin() ? 'Администратор' : 'Пользователь';
      $btn_edit = MrLink::open('new_user_office_toggle_admin', ['office_id'=>$new_user->getOffice()->id(),'id' => $new_user->id()], '', 'btn btn-primary btn-xs fa fa-edit');
      //$row[] = array($privileges, $btn_edit);
      // удалить
      //$row[] = MrLink::open('new_user_delete', ['id' => $new_user->id()], '', 'btn btn-primary btn-xs fa fa-trash-alt');


      $rows[] = $row;
    }


    foreach ($has_users as $item)
    {
      $row = array();
      /** @var MrUserInOffice $item */
      $row[] = $item->getUser()->GetFullName();

      // привилегии пользователя
      $privileges = $item->getIsAdmin() ? 'Администратор' : 'Пользователь';
      //$btn_edit = MrLink::open('user_office_toggle_admin', ['office_id'=>$item->getOffice()->id(),'id' => $item->id()], '', 'btn btn-primary btn-xs fa fa-edit');
      $row[] = array($privileges, $btn_edit);
      // удалить
     // $row[] = MrLink::open('user_delete', ['id' => $item->id()], '', 'btn btn-primary btn-xs fa fa-trash-alt');

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $has_users);
  }
}