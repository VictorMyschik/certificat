<?php


namespace App\Http\Controllers\TableControllers\References;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrUser;
use App\Models\References\MrCurrency;

class MrReferencesCurrencyTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $user = MrUser::me();
    $can_edit = false;

    if($user && $user->IsSuperAdmin())
    {
      $can_edit = true;
    }

    $body = MrCurrency::Select(['id'])->paginate($on_page);

    $collections = $body->getCollection();

    foreach ($body->getCollection() as $model)
    {
      $item = MrCurrency::loadBy($model->id);
      unset($model->id);
      $model->Name = $item->getName();
      $model->TextCode = $item->getTextCode();
      $model->DateFrom = $item->getDateFrom() ? $item->getDateFrom()->getShortDate() : '';
      $model->DateTo = $item->getDateTo() ? $item->getDateTo()->getShortDate() : '';
      $model->Code = $item->getCode();
      $model->Rounding = $item->getRounding();
      $model->Description = $item->getDescription();

      if($can_edit)
      {
        $model->action = array(
          $edit = MrForm::loadForm('admin_reference_currency_form_edit', ['id' => $item->id()], '', ['btn btn-success btn-xs fa fa-edit']),
          $delete = MrLink::open('reference_item_delete',
            ['name' => 'currency', 'id' => $item->id()], '',
            'btn btn-danger btn-xs fa fa-trash-alt',
            'Удалить', ['onclick' => "return confirm('Уверены?');"]),
        );
      }
    }

    $header = array(
      'Name' => 'Наименование',
      'TextCode' => 'Код',
      'DateFrom' => 'Дата с',
      'DateTo' => 'Дата по',
      'Code' => 'Цифровой код',
      'Rounding' => 'Округление',
      'Description' => 'Примечание'
    );

    if($can_edit)
    {
      $header['#'] = '#';
    }

    $body->setCollection($collections);

    return array(
      'header' => $header,
      'body' => $body
    );
  }
}