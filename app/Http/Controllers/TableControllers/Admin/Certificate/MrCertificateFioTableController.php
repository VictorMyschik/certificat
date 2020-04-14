<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrFio;

class MrCertificateFioTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrFio::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Прикреплён', 'sort' => 'ObjectKind'),
      array('name' => 'ID', 'sort' => 'ObjectID'),
      array('name' => 'Имя', 'sort' => 'FirstName'),
      array('name' => 'Отчество', 'sort' => 'MiddleName'),
      array('name' => 'Фамилия', 'sort' => 'LastName'),
      array('name' => 'Должность', 'sort' => 'PositionName'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $communicate = MrFio::loadBy($id);

    $row[] = $communicate->id();
    $row[] = $communicate->getObjectKindName();
    $row[] = $communicate->getObject()->id();
    $row[] = $communicate->getFirstName();
    $row[] = $communicate->getMiddleName();
    $row[] = $communicate->getLastName();

    $row[] = array(
      MrLink::open('admin_fio_delete', ['id' => $communicate->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}