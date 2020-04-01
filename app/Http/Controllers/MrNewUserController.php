<?php


namespace App\Http\Controllers;


use App\Models\MrNewUsers;

class MrNewUserController extends Controller
{
  public function RegistrationNewUser(string $string)
  {
    $out = array();
    $new_user = MrNewUsers::loadBy($string,'Code');

    if(!$new_user)
    {
      return redirect('/register');
    }

    $out['email'] = $new_user->getEmail();
    $out['office'] = $new_user->getOffice()->getName();
    $out['text'] = "Добавление нового пользователя в Виртуальный Офис";


    return View('new_user')->with($out);
  }
}