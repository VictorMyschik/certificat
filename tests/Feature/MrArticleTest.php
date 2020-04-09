<?php


namespace Tests\Feature;


use App\Helpers\MrDateTime;
use App\Models\MrArticle;
use App\Models\MrLanguage;
use Tests\TestCase;

class MrArticleTest extends TestCase
{
  public function testMrArticle()
  {
    /**
     * 'Kind',
     * 'LanguageID',
     * 'Text',
     * 'DateUpdate',
     * 'IsPublic',
     * // 'WriteDate',
     */

    $article = new MrArticle();
    //'Kind',
    $Kind = array_rand(MrArticle::getKinds());
    $article->setKind($Kind);
    //'LanguageID',
    $LanguageID = self::randomIDfromClass(MrLanguage::class);
    $article->setLanguageID($LanguageID);
    //'Text',
    $Text = $this->randomString(1000);
    $article->setText($Text);
    //'DateUpdate',
    $DateUpdate = MrDateTime::now();
    $article->setDateUpdate($DateUpdate);
    //'IsPublic',
    $IsPublic = true;
    $article->setIsPublic($IsPublic);
    // 'WriteDate',
    $article_id = $article->save_mr();
    $article->flush();


    //// Asserts
    $article = MrArticle::loadBy($article_id);
    $this->assertNotNull($article);

    $this->assertEquals($article->getKind(), $Kind);
    $this->assertEquals($article->getLanguage()->id(), $LanguageID);
    $this->assertEquals($article->getText(), $Text);
    $this->assertEquals($article->getDateUpdate()->getShortDate(), $DateUpdate->getShortDate());
    $this->assertTrue($article->getIsPublic());
    $this->assertNotNull($article->getWriteDate());


    //// Update
    //'Kind',
    $Kind = array_rand(MrArticle::getKinds());
    $article->setKind($Kind);
    //'LanguageID',
    $LanguageID = self::randomIDfromClass(MrLanguage::class);
    $article->setLanguageID($LanguageID);
    //'Text',
    $Text = $this->randomString(1000);
    $article->setText($Text);
    //'DateUpdate',
    $DateUpdate = MrDateTime::now();
    $article->setDateUpdate($DateUpdate);
    //'IsPublic',
    $IsPublic = true;
    $article->setIsPublic($IsPublic);
    // 'WriteDate',
    $article_id = $article->save_mr();
    $article->flush();


    //// Asserts
    $article = MrArticle::loadBy($article_id);
    $this->assertNotNull($article);

    $this->assertEquals($article->getKind(), $Kind);
    $this->assertEquals($article->getLanguage()->id(), $LanguageID);
    $this->assertEquals($article->getText(), $Text);
    $this->assertEquals($article->getDateUpdate()->getShortDate(), $DateUpdate->getShortDate());
    $this->assertTrue($article->getIsPublic());
    $this->assertNotNull($article->getWriteDate());

    $article->mr_delete();
    $article->flush();

    $this->assertNull(MrArticle::loadBy($article_id));
  }
}