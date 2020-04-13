<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrFaq;

class MrAdminFaqTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrFaq::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Наименование', 'sort' => 'Title'),
        array('name' => 'Текст', 'sort' => 'Text'),
        array('name' => 'Язык', 'sort' => 'LanguageID'),
        array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $faq = MrFaq::loadBy($id);
    $row[] = $faq->id();
    $row[] = $faq->getTitle();
    $row[] = $faq->getText();
    $row[] = $faq->getLanguage()->getName();

    $row[] = array(
        MrLink::open('admin_faq_edit', ['id' => $faq->id()], '', 'btn btn-primary btn-sm fa fa-edit m-l-5',
            'Изменить'),
        MrLink::open('admin_faq_delete', ['id' => $faq->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
            'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}