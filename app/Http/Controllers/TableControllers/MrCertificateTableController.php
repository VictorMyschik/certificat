<?php


namespace App\Http\Controllers\TableControllers;


use App\Helpers\MrDateTime;
use App\Models\MrCertificate;

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
      'id' => 'ID',
      'Number' => 'Регистрационный номер документа',
      'CountryID' => 'Страна',
      'Kind' => 'Вид документа',
      'dates' => 'Срок действия',
      'Status' => 'Статус действия',
    );;


    $body->setCollection($collections);

    $out = array(
      'header' => $header,
      'body' => $body
    );

    return $out;
  }
}