<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MrUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  public function username()
  {
    $login = request()->input('identity');

    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    request()->merge([$fieldType => $login]);

    return $fieldType;
  }

  protected function validateLogin(Request $request)
  {
    $request->validate([
        $this->username() => 'required|string',
        'password' => 'required|string',
    ]);
  }

  //protected $redirectTo = '/';
  protected function redirectTo()
  {
    $user = MrUser::me();
    $user->setDateLogin();
    $user->save_mr();
    if ($def_office = $user->getDefaultOffice())
    {
      redirect()->route('office_page', ['office_id' => $def_office->id()]);
    }
    else
    {
      redirect('/');
    }
  }

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }
}