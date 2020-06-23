<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Forms\FormBase\MrForm;
use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrTranslate;

class MrAdminTranslateTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrTranslate::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('#name' => 'id', 'sort' => 'id'),
        array('#name' => 'Слово', 'sort' => 'Name'),
        array('#name' => 'LanguageID', 'sort' => 'LanguageID'),
        array('#name' => 'Перевод', 'sort' => 'Translate'),
        array('#name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $translate = MrTranslate::loadBy($id);

    $row[] = $translate->id();
    $row[] = $translate->getName();
    $row[] = $translate->getLanguage()->getName();
    $row[] = $translate->getTranslate();

    $row[] = array(
        MrForm::loadForm('translate_word_edit', ['id' => $translate->id()], '', ['btn', 'btn-primary', 'btn-sm', 'fa', 'fa-edit']),
        MrLink::open('translate_word_delete', ['id' => $translate->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
            'Удалить перевод', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}