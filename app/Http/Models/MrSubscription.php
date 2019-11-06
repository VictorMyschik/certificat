<?php

namespace App\Http\Models;


use App\Http\Controllers\Helpers\MrMessageHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MrSubscription extends ORM
{
    public static $mr_table = 'mr_subscription';

    protected static $dbFieldsMap = array(
        'Email',
        'Date',
        'Token',
    );


    public static function loadBy($value, $field = 'id'): ?MrSubscription
    {
        return parent::loadBy((string) $value, $field);
    }

    public function save_mr()
    {
        return parent::mr_save_object($this);
    }

    // Эл. почта
    public function getEmail(): string
    {
        return $this->Email;
    }

    public function setEmail(string $value)
    {
        $this->Email = $value;
    }

    // Дата подписки
    public function getDate(): Carbon
    {

        return new Carbon($this->Date);
    }

    public function setDate(Carbon $value)
    {
        $this->Date = $value;
    }

    // Токен для удаления
    public function getToken(): string
    {
        return $this->Token;
    }

    public function setToken(string $value)
    {
        $this->Token = $value;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Создание новой подписки
     *
     * @param  string  $email
     */
    public static function Subscription(string $email)
    {
        if (!MrSubscription::loadBy($email, 'Email'))
        {
            $new_subscription = new MrSubscription();
            $new_subscription->setEmail($email);
            $new_subscription->setDate(Carbon::now());
            $new_subscription->setToken(md5(time()));
            $new_subscription->save_mr();

            MrMessageHelper::SetMessage(true, 'Email: '.$email.' успешно подписан на рассылку');
        }
        else
        {
            MrMessageHelper::SetMessage(false, 'Такой Email уже имеется');
        }
    }

    public static function GetAll()
    {
        $list = DB::table(static::$mr_table)->get(['id']);
        $out = array();
        foreach ($list as $id) {
            $out[] = parent::loadBy((string) $id->id);
        }

        return $out;
    }
}