<?php

namespace App\Http\Controllers\TableControllers\Admin;

use App\Helpers\MrLink;
use App\Helpers\MtFloatHelper;
use App\Http\Controllers\Admin\MrAdminBackUpController;
use App\Http\Controllers\TableControllers\MrTableController;
use Illuminate\Support\Facades\DB;

/**
 * Строит таблицу с имеющимися таблицами в базе данных
 */
class MrAdminBackupTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    $field_name = 'id';
    $sort = 'DESC';

    foreach (explode('&', request()->getQueryString()) as $item)
    {

      $param = explode('=', $item);
      if($param[0] == 'sort' && ($param[1] == 'asc' || $param[1] == 'desc'))
      {
        $sort = $param[1];
      }
      elseif($param[0] == 'field')
      {
        $field_name = $param[1];
      }
    }

    return DB::table('migrations')->orderBy($field_name, $sort)->paginate(50);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Таблица', 'sort' => 'migration'),
      array('name' => 'Строк'),
      array('name' => 'Переустановить'),
      array('name' => 'Восстановить'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $model = DB::table('migrations')->where('id', $id)->get()->first();

    $class_name = substr($model->migration, 25, strlen($model->migration));
    $class_name = substr($class_name, 0, strlen($class_name) - 6);
    $class_name_out = '';

    foreach (explode('_', $class_name) as $tmp_str)
    {
      $class_name_out .= ucfirst($tmp_str);
    }

    $object = null;

    if(class_exists("App\\Models\\" . $class_name_out))
    {
      $object = "App\\Models\\" . $class_name_out;
    }
    elseif(class_exists("App\\Models\\References\\" . $class_name_out))
    {
      $object = "App\\Models\\References\\" . $class_name_out;
    }
    elseif(class_exists("App\\Models\\Certificate\\" . $class_name_out))
    {
      $object = "App\\Models\\Certificate\\" . $class_name_out;
    }
    elseif(class_exists("App\\Models\\Office\\" . $class_name_out))
    {
      $object = "App\\Models\\Office\\" . $class_name_out;
    }
    elseif(class_exists("App\\Models\\Lego\\" . $class_name_out))
    {
      $object = "App\\Models\\Lego\\" . $class_name_out;
    }

    if($object)
    {
      unset($model->batch);

      $row[] = $model->id;

      $row[] = MrLink::open('admin_view_table_page', ['table_name' => $object::getTableName()], $object::getTableName(), '');
      $row[] = MtFloatHelper::formatCommon($object::count());
      $row[] = MrLink::open('migration_refresh_table', ['table_name' => $model->migration], ' refresh', 'btn btn-danger btn-sm fa fa-edit');
      $row[] = isset(MrAdminBackUpController::$tables[$object::getTableName()]) ? MrLink::open('recovery_table_data', ['table_name' => $object::getTableName()], ' Recovery', 'btn btn-success btn-sm fa fa-edit') : '';
    }

    return $row;
  }
}