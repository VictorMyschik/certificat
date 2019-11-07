<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Controllers\Helpers\MtDateTime;
use App\Http\Models\MrArticle;
use App\Http\Models\MrLanguage;
use Illuminate\Http\Request;

class MrAdminArticlesController extends Controller
{
  public function list()
  {
    $out = array();
    $out['page_title'] = 'Статьи на сайте';
    $out['list'] = MrArticle::GetAll();

    return View('Admin.mir_admin_articles')->with($out);
  }

  public function edit(Request $request, int $id)
  {
    $out = array();

    if($request->getMethod() == 'POST')
    {
      $v = $request->all();
      $article = MrArticle::loadBy($id) ?: new MrArticle();
      $article->setIsPublic((bool)isset($v['IsPublic']));
      $article->setKind($v['Kind']);
      $article->setLanguageID($v['LanguageID']);
      $article->setText($v['Text']);
      $article->setDateUpdate(MtDateTime::now());

      $id = $article->save_mr();
      MrMessageHelper::SetMessage(true, 'Сохранено');
      return redirect()->route('article_edit', ['id' => $id]);
    }

    $article = MrArticle::loadBy($id);

    $out['page_title'] = $id ? 'Редактирование ' . $article->getKindName() : 'Создание';

    $form = array();

    $form['LanguageID'] = array(
      '#type' => 'select',
      '#title' => 'Язык',
      '#default_value' => $article ? $article->getLanguage()->id() : 0,
      '#value' => MrLanguage::SelectList(),
    );

    $form['Kind'] = array(
      '#type' => 'select',
      '#title' => 'Тип',
      '#default_value' => $article ? $article->getKind() : 0,
      '#value' => [0 => 'не выбрано'] + MrArticle::getKinds(),
      '#required' => true,
    );

    $form['Text'] = array(
      '#type' => 'textarea',
      '#title' => 'Текст',
      '#value' => $article ? $article->getText() : null,
      '#ckeditor' => true,
    );

    $form['IsPublic'] = array(
      '#type' => 'checkbox',
      '#title' => 'Опубликовать',
      '#value' => 1,
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