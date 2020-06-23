<?php

namespace App\Forms;

use App\Forms\FormBase\MrFormBase;
use App\Models\Office\MrOffice;
use App\Models\MrUser;
use App\Models\Office\MrUserInOffice;
use Illuminate\Http\Request;

/**
 * Форма создания пустого офиса
 */
class MrOfficeEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $office = MrUser::me()->getDefaultOffice();

    $form['#title'] = $args['office_id'] ? 'Переименовать офис' : 'Создание нового офиса';

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование офиса',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getName() : null,
    );

    $form['Description'] = array(
      '#type'  => 'textarea',
      '#title' => 'Примечание (для себя)',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getDescription() : null,
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

    if(!$v['id'] && $v['Name'])
    {
      if(MrOffice::loadBy($v['Name'], 'Name'))
      {
        $out['Name'] = 'Такой офис уже существует, выберите другое название';
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

    $office = MrUser::me()->getDefaultOffice();

    $office->setName($v['Name']);
    $office->setDescription($v['Description'] ?: null);
    $office->save_mr();

    return;
  }
}