<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrConformityAuthority;

class MrCertificateAuthorityTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrConformityAuthority::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Номер органа', 'sort' => 'ConformityAuthorityId'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Документ, подтверждающий аккредитацию', 'sort' => 'DocumentNumber'),
      array('name' => 'Дата регистрации документа', 'sort' => 'DocumentDate'),
      array('name' => 'Руководитель', 'sort' => 'OfficerDetailsID'),
      array('name' => 'Адрес 1'),
      array('name' => 'Адрес 2'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $authority = MrConformityAuthority::loadBy($id);

    $row[] = $authority->id();
    $row[] = $authority->getConformityAuthorityId();
    $row[] = $authority->getName();
    $row[] = $authority->getCountry()->getName();
    $row[] = $authority->getDocumentNumber();
    $row[] = $authority->getDocumentDate() ? $authority->getDocumentDate()->getShortDate() : null;

    $fio = '';
    if($authority->getOfficerDetails())
    {
      $fio = ['<div>' . $authority->getOfficerDetails()->GetFullName() . '</div>', $authority->getOfficerDetails()->getPositionName()];
    }

    $row[] = $fio;

    $row[] = $authority->getAddress1() ? $authority->getAddress1()->GetFullAddress() : null;
    $row[] = $authority->getAddress2() ? $authority->getAddress2()->GetFullAddress() : null;

    $row[] = array(
      MrLink::open('admin_authority_delete', ['id' => $authority->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}