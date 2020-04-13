<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrManufacturer;

class MrCertificateManufacturerTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrManufacturer::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $manufacturer = MrManufacturer::loadBy($id);

    $row[] = $manufacturer->id();
    $row[] = $manufacturer->getName();
    $row[] = $manufacturer->getCountry()->getName();

    $row[] = array(
      MrLink::open('admin_manufacturer_delete', ['id' => $manufacturer->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}