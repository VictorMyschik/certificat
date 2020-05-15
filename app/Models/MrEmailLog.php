<?php

namespace App\Models;

use App\Helpers\MrDateTime;

class MrEmailLog extends ORM
{
  protected $table = 'mr_email_log';
  public static $className = MrEmailLog::class;

  protected $fillable = array(
    'UserID',
    'Email',
    'Title',
    'Text',
    //'WriteDate',
  );

  public function after_save()
  {
  }

  // Email
  public function getUser(): MrUser
  {
    return MrUser::loadBy($this->UserID);
  }

  public function setUserID(int $value): void
  {
    $this->UserID = $value;
  }

  // Email
  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value): void
  {
    $this->Email = $value;
  }


  // Заголовок письма
  public function getTitle(): string
  {
    return $this->Title;
  }

  public function setTitle(string $value): void
  {
    $this->Title = $value;
  }


  // Текст письма
  public function getText(): ?string
  {
    return $this->Text;
  }

  public function setText(?string $value): void
  {
    $this->Text = $value;
  }

  // Дата отправки
  public function getWriteDate(): MrDateTime
  {
    return $this->getDateNullableField('WriteDate');
  }
}