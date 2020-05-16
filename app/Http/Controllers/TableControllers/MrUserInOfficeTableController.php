<?php

namespace App\Http\Controllers\TableControllers;

use App\Helpers\MrLink;
use App\Models\MrUser;
use App\Models\Office\MrUserInOffice;

class MrUserInOfficeTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrUserInOffice::where('OfficeID', $args['office_id'])->orderBy('id', 'ASC')->paginate(100);
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

    $uio = MrUserInOffice::loadBy($id);

    $row[] = $uio->getUser()->GetFullName();
    $row[] = $uio->getIsAdmin() ? __('mr-t.Админ') : __('mr-t.Пользователь');

    $office = $uio->getOffice();

    // смена прав пользователя
    if($me->IsAdminInOffice($office))
    {
      $btn_edit = MrLink::open('user_office_toggle_admin', ['office_id' => $office->id(), 'id' => $id], '', 'btn btn-primary btn-sm fa fa-edit');
    }

    // Удалить пользователя их ВО. Себя удалить нельзя
    if($me->id() != $uio->getUser()->id() && $me->IsAdminInOffice($office))
    {
      $delete = MrLink::open(
        'user_in_office_delete',
        ['id' => $uio->id()],
        '',
        'btn btn-danger btn-sm fa fa-trash-alt',
        'Удалить пользователя из ВО', ['onclick' => 'return confirm("Уверены?");']
      );
    }

    $row[] = array($btn_edit ?? null, $delete ?? null);


    return $row;
  }
}