<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;

class MrEmailLog extends ORM
{
  public static $mr_table = 'mr_email_log';
  public static $className = MrEmailLog::class;

  protected static $dbFieldsMap = array(
      'UserID',
      'Email',
      'Title',
      'Text',
    //'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrEmailLog
  {
    return parent::loadBy((string)$value, $field);
  }

  public function after_save()
  {
  }

  // Email
  public function getUser(): MrUser
  {
    return MrUser::loadBy($this->UserID);
  }

  public function setUserID(int $value)
  {
    $this->UserID = $value;
  }

  // Email
  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value)
  {
    $this->Email = $value;
  }


  // Заголовок письма
  public function getTitle(): string
  {
    return $this->Title;
  }

  public function setTitle(string $value)
  {
    $this->Title = $value;
  }


  // Текст письма
  public function getText(): ?string
  {
    return $this->Text;
  }

  public function setText(?string $value)
  {
    $this->Text = $value;
  }

  // Дата отправки
  public function getWriteDate(): MtDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }
}