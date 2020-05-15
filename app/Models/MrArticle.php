<?php

namespace App\Models;

use App\Helpers\MrDateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrArticle extends ORM
{
  public $timestamps = false;
  protected $table = 'mr_articles';
  public static $className = MrArticle::class;

  protected $fillable = array(
    'Kind',
    'LanguageID',
    'Text',
    'DateUpdate',
    'IsPublic',
    //'WriteDate',
  );

  const KIND_UNKNOWN = 0;
  const KIND_POLICY = 1;
  const KIND_API = 2;

  protected static $kinds = array(
    self::KIND_POLICY => 'Политика приватности',
    self::KIND_API    => 'API',
  );

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

  public function setKind(int $value): void
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

  public function setLanguageID(int $value): void
  {
    $this->LanguageID = $value;
  }

  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value): void
  {
    $this->Text = $value;
  }

  public function getDateUpdate(): ?MrDateTime
  {
    return $this->getDateNullableField('DateUpdate');
  }

  public function setDateUpdate($value): void
  {
    $this->setDateNullableField($value, 'DateUpdate');
  }

  public function getIsPublic(): bool
  {
    return (bool)$this->IsPublic;
  }

  public function setIsPublic(bool $value): void
  {
    $this->IsPublic = $value;
  }

  public function getWriteDate(): MrDateTime
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
      return DB::table(MrArticle::getTableName())->get(['id', 'Kind', 'LanguageID', 'IsPublic'])->toArray();
    });
  }

}