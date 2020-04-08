<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Helpers\MrLink;
use App\Http\Controllers\Admin\MrAdminBackUpController;
use App\Http\Controllers\TableControllers\MrTableController;
use Illuminate\Support\Facades\DB;

class MrAdminBackupTableController extends MrTableController
{
  public static function buildTable()
  {
    foreach (explode('&', request()->getQueryString()) as $item)
    {
      $field_name = 'id';
      $sort = 'DESC';

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


    $body = DB::table('migrations')->orderBy($field_name, $sort)->paginate(50);

    $collections = $body->getCollection();

    foreach ($collections as $model)
    {
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

      if($object)
      {
        unset($model->batch);

        $model->id;

        $model->name = MrLink::open('admin_view_table_page', ['table_name' => $object::$mr_table], $object::$mr_table, '');
        $model->action = MrLink::open('migration_refresh_table', ['table_name' => $model->migration], ' refresh', 'btn btn-danger btn-sm fa fa-edit');
        $model->recovery = isset(MrAdminBackUpController::$tables[$object::$mr_table]) ? MrLink::open('recovery_table_data', ['table_name' => $object::$mr_table], ' Recovery', 'btn btn-success btn-sm fa fa-edit') : '';
        $model->countRows = $object::getCount();
        unset($model->migration);
      }
      else
      {
        $model->action = null;
        $model->recovery = null;
      }
    }

    $header = array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Таблица', 'sort' => 'migration'),
      array('name' => 'Переустановить'),
      array('name' => 'Восстановить'),
      array('name' => 'Строк'),
    );

    $body->setCollection($collections);

    return array(
      'header' => $header,
      'body' => $body
    );
  }
}