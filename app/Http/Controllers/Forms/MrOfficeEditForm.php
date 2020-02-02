<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrOffice;
use App\Http\Models\MrUser;
use App\Http\Models\MrUserInOffice;
use Illuminate\Http\Request;

/**
 * Форма создания пустого офиса
 */
class MrOfficeEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $office = MrOffice::loadBy($id);
    $form['#title'] = $id ? 'Переименовать офис' : 'Создание нового офиса';

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование офиса',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getName() : null,
    );

    $form['Description'] = array(
      '#type' => 'textarea',
      '#title' => 'Примечание (для себя)',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getDescription() : null,
      '#rows' => 5,
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

    $office = MrOffice::loadBy($id) ?: new MrOffice();

    $office->setName($v['Name']);
    $office->setDescription($v['Description'] ?: null);
    $office_id = $office->save_mr();

    if(!$id)
    {
      $uio = new MrUserInOffice();
      $uio->setUserID(MrUser::me()->id());
      $uio->setOfficeID($office_id);
      $uio->setIsAdmin(true);
      $uio->save_mr();
    }

    return;
  }
}