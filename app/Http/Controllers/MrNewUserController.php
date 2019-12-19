<?php


namespace App\Http\Controllers;


use App\Http\Models\MrNewUsers;

class MrNewUserController extends Controller
{
  public function RegistrationNewUser(int $id)
  {
    $out = array();
    $new_user = MrNewUsers::loadBy($id);

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