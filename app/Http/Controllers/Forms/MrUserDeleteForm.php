<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrParticipant;
use App\Models\MrUser;
use Illuminate\Http\Request;

class MrUserDeleteForm extends MrFormBase
{
  protected static function builderForm()
  {
    parent::getFormBuilder($out);
    $out['title'] = 'Удаление пользователя с платформы';
    $out['btn_success'] = 'Удалить';
    return View('Form.user_delete_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    return $out;
  }

  protected static function submitForm(Request $request)
  {
    $errors = self::validateForm($request->all());
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $user = MrUser::me();
    MrParticipant::DeleteUserResults($user, (bool)$request->get('save_results', null));

    $user->AccountDelete();

    return;
  }
}