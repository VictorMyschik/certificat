<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MrDateTime;
use App\Http\Controllers\Controller;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use App\Models\Office\MrUserInOffice;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/office';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param array $data
   * @return \Illuminate\Contracts\Validation\Validator
   * @throws \Exception
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name'     => ['required', 'string', 'max:255'],
      'office'   => ['required', 'string', 'max:255', 'unique:mr_offices,Name'],
      'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param array $data
   * @return RedirectResponse
   * @throws \Exception
   */
  protected function create(array $data)
  {
    $user = User::create([
      'name'     => $data['name'],
      'email'    => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $office = new MrOffice();
    $office->setName($data['office']);
    $office_id = $office->save_mr();

    $mr_user = new MrUser();
    $mr_user->setUserLaravelID($user->id);
    $mr_user->setDateFirstVisit(MrDateTime::now());
    $mr_user->setDateLastVisit(MrDateTime::now());
    $mr_user->setDateLogin();
    $mr_user->setDefaultOfficeID($office_id);
    $mr_user_id = $mr_user->save_mr();

    $uio = new MrUserInOffice();
    $uio->setIsAdmin(true);
    $uio->setOfficeID($office_id);
    $uio->setUserID($mr_user_id);

    $uio->save_mr();

    return $user;
  }
}
