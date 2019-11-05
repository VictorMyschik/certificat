<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrGame;
use App\Models\MrUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Кабинет пользователя
 */
class MrUserController extends Controller
{
  #region Panel
  public function View()
  {

  }

  public function Edit(Request $request)
  {
    $user_laravel = Auth::user();

    $messages = [
      'max' => 'Максимальня длина поля ":attribute" :max символов.',
      'min' => 'Минимальная длина поля ":attribute" :min символов.',
      'required' => 'Поле ":attribute" обязательно к заполнению.',
      'unique' => ':attribute уже занят.',
      'same' => ':attribute и :other должны совпадать.',
    ];

    Validator::make(
      $request->all(),
      [
        //'FirstName' => 'max:50',
        //'MiddleName' => 'max:50',
        //'LastName' => 'max:50',
        'Email' => [
          'required',
          'email',
          Rule::unique('users')->ignore($user_laravel->email, 'email')
        ],
        'name' => [
          'required',
          'min:3',
          Rule::unique('users')->ignore($user_laravel->name, 'name')
        ],
        'Password' => "nullable|min:6|same:password_confirm",
      ],
      $messages
    )->validate();

    $user = MrUser::me();
    //$user->setFirstName($request->get('FirstName', null));
    //$user->setMiddleName($request->get('MiddleName', null));
    //$user->setLastName($request->get('LastName', null));
    $user_laravel->email = $request->get('Email', null);
    $user_laravel->name = $request->get('name', null);

    if($pass = $request->get('Password', null))
    {
      if(strlen($pass) > 5)
      {
        $user_laravel->password = Hash::make($pass);
      }
    }

    $user_laravel->update();

    $user->save_mr();

    MrMessageHelper::SetMessage(true, 'Информация о пользователе обновлена');

    return redirect()->route('panel');
  }
  #endregion
}