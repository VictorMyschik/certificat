<?php

namespace App\Forms;

use App\Forms\FormBase\MrFormBase;
use App\Models\MrUser;
use App\Models\Office\MrOffice;
use App\Models\Office\MrUserInOffice;
use Illuminate\Http\Request;

/**
 * Создание пустого офиса
 */
class MrNewOfficeEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    if(MrUser::me()->getDefaultOffice())
    {
      print('Disable create second office');
      exit;
    }

    $form['#title'] = 'Создание нового офиса';

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование офиса',
      '#class' => ['mr-border-radius-5'],
      '#value' => null,
    );

    $form['Description'] = array(
      '#type'  => 'textarea',
      '#title' => 'Примечание (для себя)',
      '#class' => ['mr-border-radius-5'],
      '#value' => null,
      '#rows'  => 5,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Name'])
    {
      $out['Name'] = 'Наименование обязательно';
    }
    else
    {
      if(MrOffice::loadBy($v['Name'], 'Name'))
      {
        $out['Name'] = 'Такой офис уже существует, выберите другое название';
      }
    }

    return $out;
  }

  protected static function submitForm(Request $request)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all());
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $office = new MrOffice();

    $office->setName($v['Name']);
    $office->setDescription($v['Description'] ?: null);
    $office_id = $office->save_mr();

    $user = MrUser::me();

    $uio = new MrUserInOffice();
    $uio->setUserID($user->id());
    $uio->setOfficeID($office_id);
    $uio->setIsAdmin(true);
    $uio->save_mr();

    $user->setDefaultOfficeID($office_id);
    $user->save_mr();

    return;
  }
}