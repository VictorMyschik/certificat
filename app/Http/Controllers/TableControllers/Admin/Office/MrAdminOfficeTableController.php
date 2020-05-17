<?php

namespace App\Http\Controllers\TableControllers\Admin\Office;

use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Office\MrOffice;

class MrAdminOfficeTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrOffice::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Email'),
      array('name' => 'ФИО', 'sort' => 'PersonFIO'),
      array('name' => 'Доолжность', 'sort' => 'PersonPost'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $office = MrOffice::loadBy($id);
    $row[] = $office->id();
    $row[] = '<div>' . $office->getName() . '</div><div class="mr-muted">' . $office->getDescription() . '</div>';

    $country = $office->getCountry() ? $office->getCountry()->getName() : '';
    $row[] = '<div>' . $office->getURCity() . '</div><div class="mr-muted">' . $country . '</div>';

    $row[] = '<div>' . $office->getEmail() . '</div><div class="mr-muted">' . $office->getPhone() . '</div>';
    $row[] = $office->getPersonFIO();
    $row[] = $office->getPersonPost();
    $row[] = array(
      MrForm::loadForm('admin_office_edit', ['office_id' => $office->id()], '', ['btn btn-primary btn-sm fa fa-edit']),
      MrLink::open('admin_article_delete', ['office_id' => $office->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}