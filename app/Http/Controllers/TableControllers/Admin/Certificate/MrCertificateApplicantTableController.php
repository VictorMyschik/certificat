<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrApplicant;

class MrCertificateApplicantTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrApplicant::Select()->paginate(100, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Принявший сертификат', 'sort' => 'FioID'),
      array('name' => 'Адрес 1'),
      array('name' => 'Адрес 2'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $authority = MrApplicant::loadBy($id);

    $row[] = $authority->id();
    $row[] = $authority->getName();
    $row[] = $authority->getCountry()->getName();
    $row[] = $authority->getFio() ? $authority->getFio()->GetFullName() : null;
    $row[] = $authority->getAddress1() ? $authority->getAddress1()->GetFullAddress() : null;
    $row[] = $authority->getAddress2() ? $authority->getAddress2()->GetFullAddress() : null;

    $row[] = array(
      MrLink::open('admin_applicant_delete', ['id' => $authority->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}