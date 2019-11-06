<?php


namespace App\Http\Models;


use Illuminate\Support\Facades\DB;

class MrFaq extends ORM
{
  public static $mr_table = 'mr_faq';
  public static $className = MrFaq::class;
  protected $id = 0;

  protected static $dbFieldsMap = array(
    'Title',
    'Text',
  );

  public static function loadBy($value, $field = 'id'): ?MrFaq
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
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

  ///////////////////////////////////////////////////////////////////
  public static function GetAll()
  {
    $list = DB::table(static::$mr_table)->get(['id']);
    $out = array();
    foreach ($list as $id) {
      $out[] = MrFaq::loadBy($id->id);
    }
    return $out;
  }

}