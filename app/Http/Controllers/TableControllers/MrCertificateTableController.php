<?php


namespace App\Http\Controllers\TableControllers;


use App\Helpers\MrDateTime;
use App\Models\MrCertificate;
use Illuminate\Support\Collection;

class MrCertificateTableController extends MrTableController
{
  public static function buildTable(int $on_page)
  {
    $data = MrCertificate::Select(['id'])->paginate($on_page);


    /** @var Collection $collections */
    $collections = $data->getCollection();

    foreach ($data->getCollection() as $model)
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
     'id'=>'ID',
     'number'=>'Регистрационный номер документа',
     'country'=>'Страна',
     'kind_name'=>'Вид документа',
     'dates'=>'Срок действия',
     'status'=>'Статус действия',
    );;


    $collections->prepend($header);

    $data->setCollection($collections);



    return $data;
  }
}