<?php


namespace App\Http\Controllers\TableControllers\References;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrCertificateKind;

/**
 * Классификатор видов документов об оценке соответствия
 */
class MrReferencesCertificateKindTableController extends MrTableController
{
  private static $can_edit = false;

  public static function GetQuery(array $args = array())
  {
    return MrCertificateKind::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    $out = array(
      array('#name' => __('mr-t.Код'), 'sort' => 'Code'),
      array('#name' => __('mr-t.Условное обозначение'), 'sort' => 'ShortName'),
      array('#name' => __('mr-t.Наименование'), 'sort' => 'Name'),
      array('#name' => __('mr-t.Примечание'), 'sort' => 'Description'),
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

    $currency = MrCertificateKind::loadBy($id);

    $row[] = $currency->getCode();
    $row[] = $currency->getShortName();
    $row[] = $currency->getName();
    $row[] = $currency->getDescription();

    if(self::$can_edit)
    {
      $row[] = array(
        $edit = MrForm::loadForm('admin_reference_certificate_kind_form_edit', ['id' => $currency->id()],
          '', ['btn btn-success btn-sm fa fa-edit']),
        $delete = MrLink::open('reference_item_delete',
          ['name' => 'certificate_kind', 'id' => $currency->id()], '',
          'm-l-5 btn btn-danger btn-sm fa fa-trash-alt',
          'Удалить', ['onclick' => "return confirm('Уверены?');"]),
      );
    }

    return $row;
  }
}