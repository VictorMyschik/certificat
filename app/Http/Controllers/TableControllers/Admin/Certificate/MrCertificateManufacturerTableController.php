<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrManufacturer;

class MrCertificateManufacturerTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrManufacturer::Select(['id'])->paginate($on_page);

    $collections = $body->getCollection();

    foreach ($body->getCollection() as $model)
    {
      $item = MrManufacturer::loadBy($model->id);

      $model->id = $item->id();
      $model->number = $item->getName();
      $model->country = $item->getCountry()->getName();
      $model->action = MrLink::open('manufacturer_delete', ['id' => $model->id], '',
        'btn btn-danger btn-sm fa fa-trash', 'Удалить',
        ['onclick' => "return confirm('Уверены?');"]);
    }

    $header = array(
      array('sort' => 'id', 'name' => 'ID'),
      array('sort' => 'Name', 'name' => 'Наименование'),
      array('sort' => 'CountryID', 'name' => 'Страна'),
      array('name' => '#'),
    );;


    $body->setCollection($collections);

    return array(
      'header' => $header,
      'body' => $body
    );
  }
}