<?php


namespace App\Forms;


use App\Forms\FormBase\MrFormBase;
use App\Helpers\MrMessageHelper;
use App\Models\MrUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MrUserEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $user = MrUser::loadBy($id);
    $form['Login'] = array(
      '#type' => 'textfield',
      '#title' => 'Login',
      '#class' => ['mr-border-radius-5'],
      '#value' => $user ? $user->getName() : null,
    );

    $form['Email'] = array(
      '#type' => 'textfield',
      '#title' => 'Email',
      '#class' => ['mr-border-radius-5'],
      '#value' => $user ? $user->getEmail() : null,
    );

    $form['Password'] = array(
      '#type' => 'textfield',
      '#title' => 'Password',
      '#class' => ['mr-border-radius-5'],
      '#value' => null,
    );

    $form['Password_confirm'] = array(
      '#type' => 'textfield',
      '#title' => 'Password repeat',
      '#class' => ['mr-border-radius-5'],
      '#value' => null,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    foreach (MrUser::GetAll() as $user)
    {
      if($user->id() !== $v['id'])
      {
        if($user->getEmail() == $v['Email'])
        {
          $out['Email'] = 'Этот Email уже занят';
        }

        if($user->getName() == $v['Login'] && $user->id() !== $v['id'])
        {
          $out['Login'] = 'Этот Login уже занят';
        }
      }
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $user = MrUser::loadBy($id);
    $user_laravel = $user->getUserLaravel();

    $user_laravel->email = $v['Email'];
    $user_laravel->name = $v['Login'];

    if($pass = $v['Password'])
    {
      if(strlen($pass) > 5)
      {
        $user_laravel->password = Hash::make($pass);
      }
    }

    $user_laravel->update();

    $user->save_mr();

    MrMessageHelper::SetMessage(true, "");

    return;
  }
}