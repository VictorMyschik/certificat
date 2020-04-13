<?php


namespace App\Http\Controllers\TableControllers;


use App\Http\Controllers\Controller;

class MrTableController extends Controller
{
  public static function buildTable(string $class_name, array $args = array())
  {
    $data = $class_name::GetQuery($args);

    $collections = $data->getCollection();

    foreach ($collections as $key => $model)
    {
      $id = $model->id;

      $row[] = $class_name::buildRow($id);


      $data->setCollection(collect($row));
    }

    $header = $class_name::getHeader();

    $out = array(
      'header' => $header,
      'body'   => $data
    );

    return $out;
  }
}