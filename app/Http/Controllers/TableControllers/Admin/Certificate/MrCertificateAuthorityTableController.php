<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrConformityAuthority;

class MrCertificateAuthorityTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrConformityAuthority::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Номер органа', 'sort' => 'ConformityAuthorityId'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Документ, подтверждающий аккредитацию', 'sort' => 'DocumentNumber'),
      array('name' => 'Дата регистрации документа', 'sort' => 'DocumentDate'),
      array('name' => 'Руководитель органа по оценке соответствия', 'sort' => 'OfficerDetailsID'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $authority = MrConformityAuthority::loadBy($id);

    $row[] = $authority->id();
    $row[] = $authority->getConformityAuthorityId();
    $row[] = $authority->getCountry()->getName();
    $row[] = $authority->getDocumentNumber();
    $row[] = $authority->getDocumentDate() ? $authority->getDocumentDate()->getShortDate() : null;
    $row[] = [$authority->getOfficerDetails()->GetFullName(), $authority->getOfficerDetails()->getPositionName()];

    $row[] = array(
      MrLink::open('admin_authority_delete', ['id' => $authority->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}