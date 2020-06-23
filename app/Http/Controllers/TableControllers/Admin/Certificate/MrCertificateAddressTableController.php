<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrAddress;

class MrCertificateAddressTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrAddress::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('#name' => 'id', 'sort' => 'id'),
      array('#name' => 'Страна', 'sort' => 'CountryID'),
      array('#name' => 'Код территории', 'sort' => 'TerritoryCode'),
      array('#name' => 'Регион', 'sort' => 'RegionName'),
      array('#name' => 'Район', 'sort' => 'DistrictName'),
      array('#name' => 'Город', 'sort' => 'City'),
      array('#name' => 'Населённый пункт', 'sort' => 'SettlementName'),
      array('#name' => 'Улица', 'sort' => 'StreetName'),
      array('#name' => 'Номер здания', 'sort' => 'BuildingNumberId'),
      array('#name' => 'Номер помещения', 'sort' => 'RoomNumberId'),
      array('#name' => 'Почтовый индекс', 'sort' => 'PostCode'),
      array('#name' => 'Номер абонентского ящика', 'sort' => 'PostOfficeBoxId'),
      array('#name' => 'Адрес в текстовой форме', 'sort' => 'AddressText'),
      array('#name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $address = MrAddress::loadBy($id);

    $row[] = $address->id();
    $row[] = $address->getCountry()->getName();
    $row[] = $address->getTerritoryCode();
    $row[] = $address->getRegionName();
    $row[] = $address->getDistrictName();
    $row[] = $address->getCity();
    $row[] = $address->getSettlementName();
    $row[] = $address->getStreetName();
    $row[] = $address->getBuildingNumberId();
    $row[] = $address->getRoomNumberId();
    $row[] = $address->getPostCode();
    $row[] = $address->getPostOfficeBoxId();
    $row[] = $address->getAddressText();

    $row[] = array(
      MrLink::open('admin_address_delete', ['id' => $address->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}