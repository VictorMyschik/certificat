<?php

namespace App\Http\Controllers;

use App\Helpers\MrDateTime;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\Office\MrUserInOffice;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MrNewUserController extends Controller
{
  public function RegistrationNewUser(string $string)
  {
    $out = array();
    $new_user = MrNewUsers::loadByOrDie($string, 'Code');

    if(!$new_user)
    {
      return redirect('/register');
    }

    $out['email'] = $new_user->getEmail();
    $out['text'] = "Добавление нового пользователя в Виртуальный Офис " . $new_user->getOffice()->getName();
    $out['string'] = $string;

    return View('new_user')->with($out);
  }

  /**
   * Регистрация пришлашённого пользователя
   *
   * @param Request $request
   * @param $string
   * @return RedirectResponse
   */
  public function RegNewUser(Request $request, $string)
  {
    $new_user = MrNewUsers::loadByOrDie($string, 'Code');

    Validator::make($request->all(), [
      'name'     => ['required', 'string', 'max:255', 'unique:users'],
      'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ])->validate();

    $user = User::create([
      'name'              => $request->get('name'),
      'email'             => $request->get('email'),
      'password'          => Hash::make($request->get('password')),
      'email_verified_at' => now(),
    ]);

    Auth::guard()->login($user);

    $mr_user = new MrUser();
    $mr_user->setUserLaravelID($user->id);
    $mr_user->setDateFirstVisit(MrDateTime::now());
    $mr_user->setDateLastVisit(MrDateTime::now());
    $mr_user->setDateLogin();
    $mr_user->setDefaultOfficeID($new_user->getOffice()->id());
    $mr_user_id = $mr_user->save_mr();

    $uio = new MrUserInOffice();
    $uio->setIsAdmin(true);
    $uio->setOfficeID($new_user->getOffice()->id());
    $uio->setUserID($mr_user_id);

    $uio->save_mr();

    $new_user->mr_delete();

    return redirect()->route('office_page');
  }
}