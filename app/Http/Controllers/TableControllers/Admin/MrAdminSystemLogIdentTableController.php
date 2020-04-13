<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrLogIdent;

class MrAdminSystemLogIdentTableController extends MrTableController
{

  public static function GetQuery(array $args = array())
  {
    return MrLogIdent::Select()->paginate(50, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Дата', 'sort' => 'Date'),
        array('name' => 'Откуда', 'sort' => 'Referer'),
        array('name' => 'Куда', 'sort' => 'Link'),
        array('name' => 'IP', 'sort' => 'Ip'),
        array('name' => 'User', 'sort' => 'User'),
        array('name' => 'UserAgent', 'sort' => 'UserAgent'),
        array('name' => 'Город', 'sort' => 'City'),
        array('name' => 'Страна', 'sort' => 'Country'),
        array('name' => 'Cookie', 'sort' => 'Cookie'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $log = MrLogIdent::loadBy($id);

    // ID
    $row[] = $log->id();
    $row[] = $log->getWriteDate()->getShortDateShortTime();
    $row[] = $log->getReferer();
    $row[] = $log->getLink();
    $row[] = $log->getIp();
    $row[] = $log->getUser() ? $log->getUser()->GetFullName() : '';
    $row[] = $log->getUserAgent();
    $row[] = $log->getCity();
    $row[] = $log->getCountry();
    $row[] = $log->getCookie();

    return $row;
  }
}