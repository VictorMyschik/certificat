<?php

namespace App\Http\Controllers\TableControllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MrTableController extends Controller
{
  /**
   * @param string $class_name Имя контроллера таблицы
   * @param array $args передаваемые аргументы для запроа в БД
   * @param array $table_attr настройки отображения таблицы
   * @return array
   */
  public static function buildTable(string $class_name, array $args = array(), array $table_attr = array())
  {
    $data = $class_name::GetQuery($args);

    $collections = $data->getCollection();

    foreach ($collections as $key => $model)
    {
      $id = $model->id;

      $row[] = $class_name::buildRow($id, $args);


      $data->setCollection(collect($row));
    }

    $header = $class_name::getHeader();

    return array(
      'header' => $header,
      'body'   => $data
    );
  }
}