<?php


namespace App\Models;


use Illuminate\Support\Facades\DB;

class MrFaq extends ORM
{
  public static $mr_table = 'mr_faq';
  public static $className = MrFaq::class;

  protected static $dbFieldsMap = array(
    'Title',
    'Text',
    'LanguageID',
  );

  public static function loadBy($value, $field = 'id'): ?MrFaq
  {
    return parent::loadBy((string)$value, $field);
  }

  // Наименование статьи
  public function getTitle(): string
  {
    return $this->Title;
  }

  public function setTitle(string $value)
  {
    $this->Title = $value;
  }


  // Наименование статьи
  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value)
  {
    $this->Text = $value;
  }

  public function getLanguage(): MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  public function setLanguageID(int $value)
  {
    $this->LanguageID = $value;
  }

  ///////////////////////////////////////////////////////////////////
  public static function GetByLanguage()
  {
    $lang = MrLanguage::getCurrentLanguage();
    $list = DB::table(self::$mr_table)->where('LanguageID', $lang->id())->get();
    return parent::LoadArray($list, self::class);
  }
}