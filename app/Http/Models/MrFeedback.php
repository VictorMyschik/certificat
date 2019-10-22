<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrFeedback extends ORM
{
  public static $mr_table = 'mr_feedback';

  protected static $dbFieldsMap = array(
    'Name',
    'Email',
    'Text',
    'Date',
  );

  public static function loadBy($value, $field = 'id'): ?MrFeedback
  {
    return parent::loadBy((string)$value, $field);
  }

  public function save_mr()
  {
    return parent::mr_save_object($this);
  }

  // Текст собщения
  public function getText(): string
  {
    return $this->Text;
  }

  public function setText(string $value)
  {
    $this->Text = $value;
  }

  // Имя отправителя
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  // Почта отправителя
  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value)
  {
    $this->Email = $value;
  }

  // Отчечено на входящее сообщение
  public function getSendMessage(): ?string
  {
    return $this->SendMessage;
  }

  public function setSendMessage(?string $value)
  {
    $this->SendMessage = $value;
  }

  // Сообщение прочитано
  public function getReadMessage(): bool
  {
    return $this->ReadMessage;
  }

  public function setReadMessage(bool $value)
  {
    $this->ReadMessage = $value;
  }

  // Дата отправки формы с сайта
  public function getDate(): Carbon
  {
    return new Carbon($this->Date);
  }

  public function setDate()
  {
    $this->Date = new Carbon();
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * @return MrFeedback[]
   */
  public static function GetAll(): array
  {
    $list = DB::table(static::$mr_table)->get(['id']);
    $out = array();
    foreach ($list as $id)
    {
      $out[] = MrFeedback::loadBy($id->id);
    }

    return $out;
  }

  public static function CountAll(): int
  {
    return $list = DB::table(static::$mr_table)->count();
  }
}