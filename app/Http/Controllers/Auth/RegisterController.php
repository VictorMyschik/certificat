<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MtDateTime;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrOffice;
use App\Http\Models\MrUser;
use App\Http\Models\MrUserInOffice;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
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
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param array $data
   * @param array $mr_validate
   * @return RedirectResponse
   * @throws \Exception
   */
  protected function create(array $data, array $mr_validate)
  {
    $new_user = $mr_validate['new_user'];
    $office_id = $mr_validate['office_id'];
    $verify = $mr_validate['verify'];

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'email_verified_at' => $verify
    ]);

    $mr_user = new MrUser();
    $mr_user->setUserLaravelID($user->id);
    $mr_user->setDateFirstVisit(MtDateTime::now());
    $mr_user->setDateLastVisit(MtDateTime::now());
    $mr_user->setDefaultOfficeID($office_id);
    $mr_user->setDateLogin();

    $id = $mr_user->save_mr();

    $is_admin = $new_user ? $new_user->getIsAdmin() : true;
    $uio = new MrUserInOffice();
    $uio->setIsAdmin($is_admin);
    $uio->setOfficeID($office_id);
    $uio->setUserID($id);
    $uio->save_mr();

    return $user;
  }

  /**
   * Валидация подключения нового пользователя к ВО
   *
   * @param array $data
   * @return array
   * @throws \Exception
   */
  public static function MrValidate(array $data)
  {
    $new_user = null;
    $office_id = null;
    $verify = null;

    // Подключение к существующему офису
    if($office = MrOffice::loadBy($data['office'], 'Name'))
    {
      $new_user = MrNewUsers::loadBy($office->id(), 'OfficeID');

      if((URL::previous() == \route('register')) || !$new_user || !$new_user->getEmail() == $data['email'])
      {
        return false;
      }

      $verify = MtDateTime::now();
      $office_id = $office->id();
    } // Создание нового офиса
    else
    {
      $office = new MrOffice();
      $office->setName($data['office']);
      $office_id = $office->save_mr();
    }

    $out = array();
    $out['new_user'] = $new_user;
    $out['office_id'] = $office_id;
    $out['verify'] = $verify;

    return $out;
  }
}
