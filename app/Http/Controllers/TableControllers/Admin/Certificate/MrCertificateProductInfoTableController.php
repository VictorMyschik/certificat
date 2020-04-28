<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrProductInfo;

class MrCertificateProductInfoTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrProductInfo::Select()->paginate(20);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Продукт', 'sort' => 'ProductID'),
      array('name' => 'Ед.изм.', 'sort' => 'MeasureID'),
      array('name' => 'Марка, модель...', 'sort' => 'InstanceId'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Описание', 'sort' => 'Description'),
      array('name' => 'Дата изготовления', 'sort' => 'ManufacturedDate'),
      array('name' => 'Срок годности', 'sort' => 'ExpiryDate'),
      array('name' => 'ТН ВЭД', 'sort' => 'Tnved'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $product_info = MrProductInfo::loadBy($id);

    $row[] = $product_info->id();
    $row[] = $product_info->getProduct()->getName();
    $row[] = $product_info->getMeasure() ? $product_info->getMeasure()->getTextCode() : null;
    $row[] = $product_info->getInstanceId();
    $row[] = $product_info->getName();
    $row[] = $product_info->getDescription();
    $row[] = $product_info->getManufacturedDate() ? $product_info->getManufacturedDate()->getShortDate() : null;
    $row[] = $product_info->getExpiryDate() ? $product_info->getExpiryDate()->getShortDate() : null;
    $row[] = $product_info->getTnved();

    $row[] = array(
      MrLink::open('admin_product_info_delete', ['id' => $product_info->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}