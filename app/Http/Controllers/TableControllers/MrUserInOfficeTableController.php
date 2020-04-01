<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Forms\FormBase\MrLink;
use App\Models\MrOffice;
use App\Models\MrUser;
use App\Models\MrUserInOffice;

class MrUserInOfficeTableController extends MrTableController
{
  public static function buildTable(array $has_users, array $new_users, MrOffice $office)
  {
    $me = MrUser::me();
    $header = array(
      __('mr-t.Пользователь'), __('mr-t.Привилегии'), '#'
    );

    $rows = array();

    foreach ($new_users as $new_user)
    {
      $row = array();
      /** @var MrUserInOffice $new_user */
      $row[] = '<span class="mr-bold mr-color-green">' . __('mr-t.Новый') . '</span> ' . $new_user->getEmail();

      // Привилегии приглашённого пользователя
      $privileges = $new_user->getIsAdmin() ? __('mr-t.Администратор') : __('mr-t.Пользователь');
      $btn_edit = null;
      if($new_user->canEdit())
      {
        $btn_edit = MrLink::open('new_user_office_toggle_admin', ['office_id' => $office->id(), 'id' => $new_user->id()], '', 'btn btn-primary btn-xs fa fa-edit');
      }
      $row[] = array($privileges, $btn_edit);

      // удалить
      if($new_user->canDelete())
      {
        $delete_new_user = MrLink::open('new_user_delete', ['office_id' => $office->id(), 'id' => $new_user->id()], '', 'btn btn-danger btn-xs fa fa-trash');
      }

      $row[] = $delete_new_user ?? null;


      $rows[] = $row;
    }


    // Пользователи в офисе
    foreach ($has_users as $item)
    {
      $row = array();
      /** @var MrUserInOffice $item */
      $row[] = $item->getUser()->GetFullName();

      // привилегии пользователя
      $privileges = $item->getIsAdmin() ? '<span class="mr-color-green">' . __('mr-t.Администратор') . '</span>' : __('mr-t.Пользователь');

      //// удалить
      $btn_edit = null;
      if($item->catEdit())
      {
        if($item->canAdminChange())
        {
          $btn_edit = MrLink::open('user_office_toggle_admin', ['office_id' => $office->id(), 'id' => $item->id()], '', 'btn btn-primary btn-xs fa fa-edit');
        }

        // Себя удалить нельзя
        if($me->id() != $item->getUser()->id() || $item->getUser()->IsSuperAdmin())
        {
          $delete = MrLink::open('user_in_office_delete', ['id' => $item->id()], '', 'btn btn-danger btn-xs fa fa-trash');
        }
      }

      $row[] = array($privileges, $btn_edit);
      $row[] = $delete ?? null;

      $rows[] = $row;
    }

    return parent::renderTable($header, $rows, $has_users);
  }
}