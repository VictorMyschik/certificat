<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrOffice;
use App\Http\Models\MrUserInOffice;
use App\Models\MrUser;
use Illuminate\Http\Request;

class MrAdminOfficeUserEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['UserID'] = array(
      '#type' => 'select',
      '#title' => 'Пользователи',
      '#value' => MrUser::SelectList(),
    );

    $form['IsAdmin'] = array(
      '#type' => 'checkbox',
      '#title' => 'Администратор',
      '#value' => 0,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['UserID'])
    {
      $out['UserID'] = 'Выберите пользователя';
    }

    $office = MrOffice::loadBy($v['id']);
    foreach ($office->GetUsers() as $user)
    {
      if($user->getUser()->id() == $v['UserID'])
      {
        $out['UserID'] = 'Этот пользователь уже добавлен';
      }
    }
    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $office = MrOffice::loadBy($id);

    $uio = new MrUserInOffice();
    $uio->setOfficeID($office->id());
    $uio->setUserID($v['UserID']);
    $uio->setIsAdmin((bool)(isset($v['IsAdmin']) && $v['IsAdmin']));

    $uio->save_mr();

    return;
  }
}