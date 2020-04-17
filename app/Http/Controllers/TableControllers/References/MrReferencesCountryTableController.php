<?php


namespace App\Http\Controllers\TableControllers\References;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrCountry;

class MrReferencesCountryTableController extends MrTableController
{
  private static $can_edit = false;

  public static function GetQuery(array $args = array())
  {
    return MrCountry::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    $out = array(
      array('name' => __('mr-t.Наименование'), 'sort' => 'Name'),
      array('name' => 'ISO-3166 alpha2', 'sort' => 'ISO3166alpha2'),
      array('name' => 'ISO-3166 alpha3', 'sort' => 'ISO3166alpha3'),
      array('name' => 'ISO-3166 numeric', 'sort' => 'ISO3166numeric'),
      array('name' => __('mr-t.Континент'), 'sort' => 'Continent'),
      array('name' => __('mr-t.Флаг'), 'sort' => 'Flag')
    );

    if(self::$can_edit)
    {
      $out[] = array('name' => '#');
    }

    return $out;
  }

  protected static function buildRow(int $id): array
  {
    $user = MrUser::me();

    if($user && $user->IsSuperAdmin())
    {
      self::$can_edit = true;
    }

    $row = array();

    $country = MrCountry::loadBy($id);

    $name = $country->getName();
    $row[] = __("mr-t.$name");
    $row[] = $country->getISO3166alpha2();
    $row[] = $country->getISO3166alpha3();
    $row[] = $country->getISO3166numeric();
    $row[] = $country->getContinentName();

    $img_name = mb_strtolower($country->getISO3166alpha2());
    $row[] = "<img style='width: 30px;' title='Flag {$country->getName() }'
                       src='https://img.geonames.org/flags/m/{$img_name}.png'
                       alt='{$country->getName()}'>";
    if(self::$can_edit)
    {
      $row[] = array(
        $edit = MrForm::loadForm('admin_reference_country_form_edit', ['id' => $country->id()], '', ['btn btn-success btn-sm fa fa-edit']),
        $delete = MrLink::open('reference_item_delete',
          ['name' => 'country', 'id' => $country->id()], '',
          'm-l-5 btn btn-danger btn-sm fa fa-trash-alt',
          'Удалить', ['onclick' => "return confirm('Уверены?');"]),
      );
    }

    return $row;
  }
}