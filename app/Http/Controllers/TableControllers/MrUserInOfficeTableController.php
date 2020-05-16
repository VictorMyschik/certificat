<?php

namespace App\Http\Controllers\TableControllers;

use App\Models\Office\MrUserInOffice;

class MrUserInOfficeTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrUserInOffice::where('OfficeID', $args['office_id'])->orderBy('id', 'ASC')->paginate(10);
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
    $row = array();

    $uio = MrUserInOffice::loadBy($id);
    $row[] = $uio->getUser()->getName();
    $row[] = $uio->getIsAdmin() ? __('mr-t.Админ') : __('mr-t.Пользователь');
    $row[] = '1';

    return $row;
  }
}