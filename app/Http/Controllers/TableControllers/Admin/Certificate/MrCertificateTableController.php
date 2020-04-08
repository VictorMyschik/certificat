<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrDateTime;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCertificate;

class MrCertificateTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCertificate::Select(['id'])->paginate($on_page);

    $collections = $body->getCollection();

    foreach ($body->getCollection() as $model)
    {
      $item = MrCertificate::loadBy($model->id);
      $model->id = $item->id();
      $model->number = $item->getNumber();
      $model->country = $item->getCountry()->getName();
      $model->kind_name = $item->getKindName();
      $model->dates = MrDateTime::GetFromToDate($item->getDateFrom(), $item->getDateTo());
      $model->status = $item->getStatusName();
    }

    $header = array(
      array('sort' => 'id', 'name' => 'ID'),
      array('sort' => 'Number', 'name' => 'Регистрационный номер документа'),
      array('sort' => 'CountryID', 'name' => 'Страна'),
      array('sort' => 'Kind', 'name' => 'Вид документа'),
      array('name' => 'Срок действия'),
      array('sort' => 'Status', 'name' => 'Статус действия'),
    );;


    $body->setCollection($collections);

    $out = array(
      'header' => $header,
      'body' => $body
    );

    return $out;
  }
}