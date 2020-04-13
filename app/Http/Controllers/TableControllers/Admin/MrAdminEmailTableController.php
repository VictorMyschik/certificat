<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrEmailLog;

class MrAdminEmailTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrEmailLog::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Кому', 'sort' => 'UserID'),
      array('name' => 'Email', 'sort' => 'Email'),
      array('name' => 'Title', 'sort' => 'Title'),
      array('name' => 'Text', 'sort' => 'Text'),
      array('name' => 'WriteDate', 'sort' => 'WriteDate'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $log = MrEmailLog::loadBy($id);

    $row[] = $log->id();
    $row[] = $log->getUser()->getName();
    $row[] = $log->getEmail();
    $row[] = $log->getTitle();
    $row[] = $log->getText();
    $row[] = $log->getWriteDate()->getShortDateShortTime();

    $row[] = array(

      MrLink::open('admin_email_delete', ['id' => $log->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}