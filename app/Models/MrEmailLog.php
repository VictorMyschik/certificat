<?php

namespace App\Models;

use App\Helpers\MrDateTime;

class MrEmailLog extends ORM
{
  protected $table = 'mr_email_log';
  protected $fillable = array(
    'AuthorUserID',
    'EmailTo',
    'Title',
    'Text',
    //'WriteDate',
  );

  public function after_save()
  {
  }

  // Email
  public function getAuthorUser(): MrUser
  {
    return MrUser::loadBy($this->AuthorUserID);
  }

  public function setAuthorUserID(int $value): void
  {
    $this->AuthorUserID = $value;
  }

  // Email
  public function getEmailTo(): string
  {
    return $this->EmailTo;
  }

  public function setEmailTo(string $value): void
  {
    $this->EmailTo = $value;
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