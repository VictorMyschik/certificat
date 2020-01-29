<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrArticle extends ORM
{
  public static $mr_table = 'mr_articles';
  public static $className = MrArticle::class;

  protected $id = 0;

  protected static $dbFieldsMap = array(
    'Kind',
    'LanguageID',
    'Text',
    'DateUpdate',
    'IsPublic',
    // 'WriteDate',
  );

  const KIND_KINDUNKNOWN = 0;
  const KIND_POLICY = 1;
  const KIND_API = 2;

  protected static $kinds = array(
    self::KIND_POLICY => 'Политика приватности',
    self::KIND_API => 'API',
  );

  public static function loadBy($value, $field = 'id'): ?MrArticle
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canDelete(): bool
  {
    return true;
  }

  public function before_delete()
  {
    Cache::forget('MrArticles_ids');
  }

  public static function getKinds(): array
  {
    return self::$kinds;
  }

  public function getKind(): int
  {
    return $this->Kind;
  }

  public function setKind(int $value)
  {
    if(self::getKinds()[$value])
    {
      $this->Kind = $value;
    }
    else
    {
      dd('Unknown Kind:' . $value);
    }
  }

  public function getKindName()
  {
    return self::getKinds()[$this->getKind()];
  }

  public function getLanguage(): MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  public function setLanguageID(int $value)
  {
    $this->LanguageID = $value;
  }

  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value)
  {
    $this->Text = $value;
  }

  public function getDateUpdate(): ?MtDateTime
  {
    return $this->getDateNullableField('DateUpdate');
  }

  public function setDateUpdate($value)
  {
    return $this->setDateNullableField($value, 'DateUpdate');
  }

  public function getIsPublic(): bool
  {
    return (bool)$this->IsPublic;
  }

  public function setIsPublic(bool $value)
  {
    $this->IsPublic = $value;
  }

  public function setWriteDate(): MtDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }

//////////////////////////////////////////////////

  /**
   * @return array
   */
  public static function GetIds()
  {
    return Cache::rememberForever('MrArticles_ids', function () {
      return DB::table(MrArticle::$mr_table)->get(['id','Kind', 'LanguageID','IsPublic'])->toArray();
    });
  }

}