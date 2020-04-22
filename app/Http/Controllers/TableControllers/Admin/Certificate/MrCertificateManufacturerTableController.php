<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrManufacturer;

class MrCertificateManufacturerTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrManufacturer::Select()->paginate(20);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Юр. адрес', 'sort' => 'Address1ID'),
      array('name' => 'Факт. адрес', 'sort' => 'Address2ID'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $manufacturer = MrManufacturer::loadBy($id);

    $row[] = $manufacturer->id();
    $row[] = $manufacturer->getCountry()->getName();
    $row[] = $manufacturer->getName();
    $row[] = $manufacturer->getAddress1() ? $manufacturer->getAddress1()->GetShortAddress() : null;
    $row[] = $manufacturer->getAddress2() ? $manufacturer->getAddress2()->GetShortAddress() : null;

    $row[] = array(
      MrLink::open('admin_manufacturer_delete', ['id' => $manufacturer->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}