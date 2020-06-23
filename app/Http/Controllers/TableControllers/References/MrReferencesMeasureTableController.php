<?php


namespace App\Http\Controllers\TableControllers\References;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrMeasure;

class MrReferencesMeasureTableController extends MrTableController
{
  private static $can_edit = false;

  public static function GetQuery(array $args = array())
  {
    return MrMeasure::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    $out = array(
      array('#name' => __('mr-t.Код'), 'sort' => 'Code'),
      array('#name' => __('mr-t.Условное обозначение'), 'sort' => 'TextCode'),
      array('#name' => __('mr-t.Наименование'), 'sort' => 'Name'),
    );

    if(self::$can_edit)
    {
      $out[] = array('#name' => '#');
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

    $currency = MrMeasure::loadBy($id);

    $row[] = $currency->getCode();
    $row[] = $currency->getTextCode();
    $row[] = $currency->getName();

    if(self::$can_edit)
    {
      $row[] = array(
        $edit = MrForm::loadForm('admin_reference_measure_form_edit', ['id' => $currency->id()], '', ['btn btn-success btn-sm fa fa-edit']),
        $delete = MrLink::open('reference_item_delete',
          ['name' => 'measure', 'id' => $currency->id()], '',
          'm-l-5 btn btn-danger btn-sm fa fa-trash-alt',
          'Удалить', ['onclick' => "return confirm('Уверены?');"]),
      );
    }

    return $row;
  }
}