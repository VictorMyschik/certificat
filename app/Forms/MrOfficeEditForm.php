<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrOffice;
use App\Models\MrUser;
use App\Models\MrUserInOffice;
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
      $user = MrUser::me();

      $uio = new MrUserInOffice();
      $uio->setUserID($user->id());
      $uio->setOfficeID($office_id);
      $uio->setIsAdmin(true);
      $uio->save_mr();

      $user->setDefaultOfficeID($office_id);
      $user->save_mr();
    }

    return;
  }
}