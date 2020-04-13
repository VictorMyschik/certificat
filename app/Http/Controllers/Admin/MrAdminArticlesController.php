<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrDateTime;
use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\MrAdminArticleTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrArticle;
use App\Models\MrLanguage;
use Illuminate\Http\Request;

class MrAdminArticlesController extends Controller
{
  public function list()
  {
    $out = array();
    $out['page_title'] = 'Статьи на сайте';
    $out['route_name'] = route('admin_article_table');

    return View('Admin.mir_admin_articles')->with($out);
  }

  /**
   * Article table
   *
   * @return array
   */
  public function GetArticleTable(): array
  {
    return MrTableController::buildTable(MrAdminArticleTableController::class);
  }

  public function edit(Request $request, int $id)
  {
    $out = array();

    $article = MrArticle::loadBy($id);

    if($request->getMethod() == 'POST')
    {
      if(!$article)
      {
        $article = new MrArticle();
      }

      if(!$request->get('LanguageID'))
      {
        MrMessageHelper::SetMessage(1, 'Выберите язык');
        return back()->withInput($request->all());
      }

      $article->setLanguageID($request->get('LanguageID'));
      $article->setText($request->get('Text'));
      $article->setIsPublic($request->get('IsPublic') ? true : false);
      $article->setKind($request->get('Kind'));
      $article->setDateUpdate(MrDateTime::now());

      $id = $article->save_mr();

      MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Сохранено');

      return redirect()->route('admin_article_page');
    }


    $form = array();

    $form['LanguageID'] = array(
      '#type'          => 'select',
      '#title'         => 'Язык',
      '#default_value' => $article ? $article->getLanguage()->id() : 0,
      '#value'         => MrLanguage::SelectList(),
    );

    $form['Kind'] = array(
      '#type'          => 'select',
      '#title'         => 'Тип',
      '#default_value' => $article ? $article->getKind() : 0,
      '#value'         => [0 => 'не выбрано'] + MrArticle::getKinds(),
      '#required'      => true,
    );

    $form['Text'] = array(
      '#type'     => 'textarea',
      '#title'    => 'Текст ответа',
      '#value'    => $article ? $article->getText() : null,
      '#ckeditor' => true,
    );

    $form['IsPublic'] = array(
      '#type'    => 'checkbox',
      '#title'   => 'Опубликовать',
      '#value'   => 1,
      '#checked' => $article ? (bool)$article->getIsPublic() : false,
    );


    $out['form'] = $form;
    $out['article'] = $article;

    return View('Admin.mir_admin_articles_edit')->with($out);
  }

  public function delete(int $id)
  {
    $article = MrArticle::loadBy($id);
    $article->mr_delete();

    return back();
  }
}