<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrArticle;

class MrAdminArticlesController extends Controller
{
  public function list()
  {
    $out = array();
    $out['page_title'] = 'Статьи на сайте';
    $out['list'] = MrArticle::GetAll();

    return View('Admin.mir_admin_articles')->with($out);
  }

  public function edit(int $id)
  {
    $article = MrArticle::loadBy($id) ?: new MrArticle();
    $out = array();

    $out['article'] = $article;

    return View()->with($out);
  }
}