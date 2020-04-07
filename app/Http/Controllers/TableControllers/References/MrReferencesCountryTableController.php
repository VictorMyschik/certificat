<?php


namespace App\Http\Controllers\TableControllers\References;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrCountry;

class MrReferencesCountryTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $user = MrUser::me();
    $can_edit = false;

    if($user && $user->IsSuperAdmin())
    {
      $can_edit = true;
    }

    $body = MrCountry::Select(['id'])->paginate($on_page);

    $collections = $body->getCollection();

    foreach ($body->getCollection() as $model)
    {
      $item = MrCountry::loadBy($model->id);
      unset($model->id);

      $model->Name = $item->getName();
      $model->Capital = $item->getCapital();
      $model->ISO3166alpha2 = $item->getISO3166alpha2();
      $model->ISO3166alpha3 = $item->getISO3166alpha3();
      $model->ISO3166numeric = $item->getISO3166numeric();
      $model->ContinentName = $item->getContinentName();

      $img_name = mb_strtolower($item->getISO3166alpha2());
      $model->Flag = "<img style='width: 30px;' title='Flag {$item->getName() }'
                       src='https://img.geonames.org/flags/m/{$img_name}.png'
                       alt='{$item->getName()}'>";

      if($can_edit)
      {
        $model->action = array(
          $edit = MrForm::loadForm('admin_reference_country_form_edit', ['id' => $item->id()], '', ['btn btn-success btn-xs fa fa-edit']),
          $delete = MrLink::open('reference_item_delete',
            ['name' => 'country', 'id' => $item->id()], '',
            'm-l-5 btn btn-danger btn-xs fa fa-trash-alt',
            'Удалить', ['onclick' => "return confirm('Уверены?');"]),
        );
      }
    }

    $header = array(
      array('name' => __('mr-t.Наименование'), 'sort' => 'Name'),
      array('name' => __('mr-t.Столица'), 'sort' => 'Capital'),
      array('name' => 'ISO-3166 alpha2', 'sort' => 'ISO3166alpha2'),
      array('name' => 'ISO-3166 alpha3', 'sort' => 'ISO3166alpha3'),
      array('name' => 'ISO-3166 numeric', 'sort' => 'ISO3166numeric'),
      array('name' => __('mr-t.Континент'), 'sort' => 'Continent'),
      array('name' => __('mr-t.Флаг'), 'sort' => 'Flag')
    );

    if($can_edit)
    {
      $header[] = array('name' => '#');
    }

    $body->setCollection($collections);

    return array(
      'header' => $header,
      'body' => $body
    );
  }
}