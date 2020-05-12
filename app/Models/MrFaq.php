<?php

namespace App\Models;

class MrFaq extends ORM
{
  protected $table = 'mr_faq';
  public static $className = MrFaq::class;

  protected static $dbFieldsMap = array(
    'Title',
    'Text',
    'LanguageID',
  );

  // Наименование статьи
  public function getTitle(): string
  {
    return $this->Title;
  }

  public function setTitle(string $value): void
  {
    $this->Title = $value;
  }


  // Наименование статьи
  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value): void
  {
    $this->Text = $value;
  }

  public function getLanguage(): MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  public function setLanguageID(int $value): void
  {
    $this->LanguageID = $value;
  }

  ///////////////////////////////////////////////////////////////////
  public static function GetByLanguage()
  {
    $lang = MrLanguage::getCurrentLanguage();
    return self::LoadArray(['LanguageID' => $lang->id()]);
  }
}