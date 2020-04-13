<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;

class MrAdminSystemDbLogTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrBaseLog::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Идентификатор', 'sort' => 'LogIdentID'),
        array('name' => 'Таблица', 'sort' => 'TableName'),
        array('name' => 'ID записи', 'sort' => 'RowId'),
        array('name' => 'Поле', 'sort' => 'Field'),
        array('name' => 'Новое знчение', 'sort' => 'Value'),
        array('name' => 'Дата', 'sort' => 'WriteDate'),
        array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $base_log = MrBaseLog::loadBy($id);

    // ID
    $row[] = $base_log->id();

    /// Пользователь
    $log_ident = $base_log->getLogIdent();

    if ($user = $log_ident->getUser())
    {
      $user_out = $user->GetFullName();
    }

    $row[] = $user_out ?? '';
    // Таблица
    $row[] = $base_log->getTable();
    $row[] = $base_log->getRowId();
    $row[] = $base_log->getField();
    $row[] = $base_log->getValue();
    $row[] = $base_log->getWriteDate()->getShortDateTitleShortTime();

    $row[] = MrLink::open('delete_bd_log_id', ['id' => $base_log->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
            'Удалить', ['onclick' => 'return confirm("Уверены?");']);

    return $row;
  }
}