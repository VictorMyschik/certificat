<?php

namespace App\Http\Controllers\TableControllers\Admin;

use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrArticle;

class MrAdminArticleTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrArticle::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('#name' => 'id', 'sort' => 'id'),
        array('#name' => 'Тип', 'sort' => 'Title'),
        array('#name' => 'Язык', 'sort' => 'LanguageID'),
        array('#name' => 'Обновлено', 'sort' => 'DateUpdate'),
        array('#name' => 'Public', 'sort' => 'Public'),
        array('#name' => 'Дата', 'sort' => 'Date'),
        array('#name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $article = MrArticle::loadBy($id);
    $row[] = $article->id();
    $row[] = $article->getKindName();
    $row[] = $article->getLanguage()->getName();
    $row[] = $article->getDateUpdate()->getShortDateTitleShortTime();
    $row[] = $article->getIsPublic() ? 'Опубликовано' : 'Черновик';
    $row[] = $article->getWriteDate()->getShortDateTitleShortTime();
    $row[] = array(
        MrLink::open('admin_article_edit', ['id' => $article->id()], '', 'btn btn-primary btn-sm fa fa-edit m-l-5',
            'Изменить'),
        MrLink::open('admin_article_delete', ['id' => $article->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
            'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}