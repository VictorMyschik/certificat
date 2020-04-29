<?php

namespace App\Http\Controllers\TableControllers\References;

use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrTechnicalReglament;

class MrReferencesTechnicalReglamentTableController extends MrTableController
{
  private static $can_edit = false;

  public static function GetQuery(array $args = array())
  {
    return MrTechnicalReglament::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    $out = array(
      array('name' => __('mr-t.Код'), 'sort' => 'Code'),
      array('name' => __('mr-t.Наименование'), 'sort' => 'Name'),
      array('name' => __('mr-t.Ссылка'), 'sort' => 'Link'),
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

    $reglament = MrTechnicalReglament::loadBy($id);

    $row[] = $reglament->getCode();
    $row[] = $reglament->getName();
    $row[] = '<a href="'.$reglament->getLink().'" target="_blank"><i class="fa fa-eye"> PDF</a>';

    if(self::$can_edit)
    {
      $row[] = array(
        $edit = MrForm::loadForm('admin_reference_technical_reglament_form_edit', ['id' => $reglament->id()],
          '', ['btn btn-success btn-sm fa fa-edit']),
        $delete = MrLink::open('reference_item_delete',
          ['name' => 'technical_reglament', 'id' => $reglament->id()], '',
          'm-l-5 btn btn-danger btn-sm fa fa-trash-alt',
          'Удалить', ['onclick' => "return confirm('Уверены?');"]),
      );
    }

    return $row;
  }
}
