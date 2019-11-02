<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrOffice;
use Illuminate\Http\Request;
/**
 * Форма создания пустого офиса
 */
class MrAdminOfficeEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $office = MrOffice::loadBy($id);

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование офиса',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getName() : null,
    );

    $form['Description'] = array(
      '#type' => 'textfield',
      '#title' => 'Примечание (для себя)',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office ? $office->getDescription() : null,
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
    $office->save_mr();


    return;
  }
}