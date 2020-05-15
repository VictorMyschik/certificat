<?php

namespace App\Models;

use App\Helpers\MrDateTime;
use App\Helpers\MrMessageHelper;
use Carbon\Carbon;

class MrSubscription extends ORM
{
  protected $table = 'mr_subscription';
  public static $className = MrSubscription::class;

  protected $fillable = array(
    'Email',
    'Date',
    'Token',
  );

  // Эл. почта
  public function getEmail(): string
  {
    return $this->Email;
  }

  public function setEmail(string $value): void
  {
    $this->Email = $value;
  }

  // Дата подписки
  public function getDate(): MrDateTime
  {
    return $this->getDateNullableField('Date');
  }

  public function setDate($value): void
  {
    $this->setDateNullableField($value, 'Date');
  }

  // Токен для удаления
  public function getToken(): string
  {
    return $this->Token;
  }

  public function setToken(string $value): void
  {
    $this->Token = $value;
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Создание новой подписки
   *
   * @param string $email
   */
  public static function Subscription(string $email)
  {
    if(!MrSubscription::loadBy($email, 'Email'))
    {
      $new_subscription = new MrSubscription();
      $new_subscription->setEmail($email);
      $new_subscription->setDate(Carbon::now());
      $new_subscription->setToken(md5(time()));
      $new_subscription->save_mr();

      MrMessageHelper::SetMessage(true, 'Email: ' . $email . ' успешно подписан на рассылку');
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Такой Email уже имеется');
    }
  }
}