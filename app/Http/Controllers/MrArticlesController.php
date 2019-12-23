<?php


namespace App\Http\Controllers;


use App\Http\Models\MrArticle;
use App\Http\Models\MrLanguage;

class MrArticlesController extends Controller
{
  /**Определение текущего языка
   * @return MrLanguage
   */
  protected static function getLanguage(): MrLanguage
  {
    $locate = app()->getLocale();
    return MrLanguage::loadBy($locate, 'Name');
  }

  /** Получение статьи на языке
   * @param int $kind
   * @return MrArticle|null
   */
  protected function getArticle(int $kind): ?MrArticle
  {
    $language = self::getLanguage();
    $article = null;

    foreach (MrArticle::GetIds() as $item)
    {
      if($item->Kind == $kind && $item->LanguageID == $language->id() && $item->IsPublic)
      {
        $article = MrArticle::loadBy($item->id);
      }
    }

    return $article;
  }

  public function ViewPolicy()
  {
    $out = array();

    $out['article'] = $this->getArticle(MrArticle::KIND_POLICY);

    return View('policy')->with($out);
  }

  public function ViewApi()
  {
    $out = array();

    $out['article'] = $this->getArticle(MrArticle::KIND_API);

    return View('api')->with($out);
  }
}