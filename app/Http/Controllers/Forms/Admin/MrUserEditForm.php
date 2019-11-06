<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MrUserEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['user'] = $user = MrUser::loadBy($id) ?: new MrUser();
    $out['title'] = $id ? "Редактирование {$user->id()}" : 'Создать';

    return View('Form.admin_user_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Login'])
      return $out = array('Login' => 'Login обязателен');

    if(!$v['Email'])
      return $out = array('Email' => 'Email обязателен');

    if((isset($v['Password']) && !isset($v['password_reset'])) || (!isset($v['Password']) && isset($v['password_reset'])))
    {
      $out['Password'] = 'При вводе пароля, оба поля необходимо заполнить.';
      $out['password_reset'] = 'При вводе пароля, оба поля необходимо заполнить.';

      return $out;
    }

    if(isset($v['Password']) && isset($v['password_reset']))
    {
      if($v['Password'] !== $v['password_reset'])
      {
        $out['Password'] = 'Пароль и повтор пароля не совпадают.';
        $out['password_reset'] = 'Пароль и повтор пароля не совпадают.';
      }
    }

    self::validateHalper($v['Login'], 'Login', 255, $out);
    self::validateHalper($v['Email'], 'Email', 255, $out);
    self::validateHalper($v['Password'], 'Password', 255, $out);

    foreach (MrUser::all() as $user)
    {
      if($user->getName() == $v['Login'] && $user->id() !== $v['id'])
      {
        $out['Login'] = 'Login уже занят';
      }

      if($user->getEmail() == $v['Email'] && $user->id() !== $v['id'])
      {
        $out['Email'] = 'Email уже занят';
      }
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
      return $errors;

    parent::submitFormBase($request->all());

    $user = MrUser::loadBy($id);

    if(!$user)
    {
      // Новый в Laravel
      $new_user = User::create([
        'name'     => $request->get('Login'),
        'email'    => $request->get('Email'),
        'password' => Hash::make($request->get('Password')),
      ]);

      $user = new MrUser();
      $user->setUserLaravelID($new_user->id);
      $user->setDateFirstVisit(Carbon::now());
      $user->setDateLogin();
    }

    $user_lara = $user->getUserLaravel();
    $user_lara->name = $request->get('Login');
    $user_lara->email = $request->get('Email');
    $user_lara->save();

    $user->setPhone($request->get('Phone'));

    $user->save_mr();

    return;
  }
}