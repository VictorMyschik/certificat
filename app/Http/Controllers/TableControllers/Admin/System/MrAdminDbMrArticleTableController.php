<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrArticle;

class MrAdminDbMrArticleTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrArticle::Select(['*'])->paginate($on_page);

    return array(
        'header' => array(
            array('name' => 'id', 'sort' => 'id'),
            array('name' => 'Kind', 'sort' => 'Kind'),
            array('name' => 'LanguageID', 'sort' => 'LanguageID'),
            array('name' => 'Text', 'sort' => 'Text'),
            array('name' => 'DateUpdate', 'sort' => 'DateUpdate'),
            array('name' => 'IsPublic', 'sort' => 'IsPublic'),
            array('name' => 'WriteDate', 'sort' => 'WriteDate'),
        ),

        'body' => $body
    );
  }
}