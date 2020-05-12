<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrFeedback extends ORM
{
  public static $className = MrFeedback::class;
  protected $table = 'mr_feedback';

  protected static $dbFieldsMap = array(
    'Name',
    'Email',
    'Text',
    'Date',
  );

  // Текст сообщения
  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value): void
  {
    $this->Text = $value;
  }

  // Имя отправителя
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value): void
  {
    $this->Name = $value;
  }

  // Почта отправителя
  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value): void
  {
    $this->Email = $value;
  }

  // Отвечено на входящее сообщение
  public function getSendMessage(): ?string
  {
    return $this->SendMessage;
  }

  public function setSendMessage(?string $value): void
  {
    $this->SendMessage = $value;
  }

  // Сообщение прочитано
  public function getReadMessage(): bool
  {
    return $this->ReadMessage;
  }

  public function setReadMessage(bool $value): void
  {
    $this->ReadMessage = $value;
  }

  // Дата отправки формы с сайта
  public function getDate(): Carbon
  {
    return new Carbon($this->Date);
  }

  public function setDate(): void
  {
    $this->Date = new Carbon();
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
}