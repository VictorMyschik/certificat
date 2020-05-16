<?php

namespace App\Http\Controllers\TableControllers;

use App\Helpers\MrLink;
use App\Models\MrNewUsers;
use App\Models\MrUser;

class MrNewUserInOfficeTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrNewUsers::where('OfficeID', $args['office_id'])->orderBy('id', 'ASC')->paginate(100);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => __('mr-t.Имя')),
      array('name' => __('mr-t.Доступ')),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $me = MrUser::me();

    $row = array();

    $new_users = MrNewUsers::loadBy($id);

    $row[] = $new_users->getEmail();
    $row[] = $new_users->getIsAdmin() ? __('mr-t.Админ') : __('mr-t.Пользователь');

    $office = $new_users->getOffice();

    // смена прав пользователя
    if($me->IsAdminInOffice($office))
    {
      $btn_edit = MrLink::open('new_user_office_toggle_admin', ['office_id' => $office->id(), 'id' => $id], '', 'btn btn-primary btn-sm fa fa-edit');

      $delete = MrLink::open(
        'new_user_delete',
        ['office_id' => $office->id(), 'id' => $new_users->id()],
        '',
        'btn btn-danger btn-sm fa fa-trash-alt',
        'Удалить пользователя из ВО', ['onclick' => 'return confirm("Уверены?");']
      );
    }

    $row[] = array($btn_edit ?? null, $delete ?? null);


    return $row;
  }
}