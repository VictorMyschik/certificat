<?php


namespace App\Models;


class MrPolicy extends ORM
{
  public static $mr_table = 'mr_policy';
  public static $className = MrTranslate::class;

  protected static $dbFieldsMap = array(
    'LanguageID',
    'Text',
  );

  public static function loadBy($value, $field = 'id'): ?MrPolicy
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  /**
   *  На русском
   *
   * @return string|null
   */
  public function getText(): ?string
  {
    return $this->Text;
  }


  public function setText(?string $value)
  {
    $this->Text = $value;
  }

  /**
   * @return MrLanguage|null
   */
  public function getLanguage(): ?MrLanguage
  {
    return MrLanguage::loadBy($this->LanguageID);
  }

  public function setLanguageID(?int $value)
  {
    $this->LanguageID = $value;
  }
//////////////////////////////////////////////////////
}