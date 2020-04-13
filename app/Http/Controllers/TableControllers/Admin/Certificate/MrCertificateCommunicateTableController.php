<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCommunicate;

/**
 *Админ. Адреса Коммуникаций
 */
class MrCertificateCommunicateTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrCommunicate::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Прикреплён', 'sort' => 'ObjectKind'),
      array('name' => 'ID', 'sort' => 'ObjectID'),
      array('name' => 'Тип связи', 'sort' => 'Kind'),
      array('name' => 'Адрес', 'sort' => 'Address'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $communicate = MrCommunicate::loadBy($id);

    $row[] = $communicate->id();
    $row[] = $communicate->getObjectKindName();
    $row[] = $communicate->getObject()->id();
    $row[] = $communicate->getKindName();
    $row[] = $communicate->getAddress();

    $row[] = array(
      MrLink::open('admin_communicate_delete', ['id' => $communicate->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}