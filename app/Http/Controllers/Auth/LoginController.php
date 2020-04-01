<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MrUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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


  //protected $redirectTo = '/';
  protected function redirectTo()
  {
    $user = MrUser::me();
    $user->setDateLogin();
    $user->save_mr();
    if($def_office = $user->getDefaultOffice())
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