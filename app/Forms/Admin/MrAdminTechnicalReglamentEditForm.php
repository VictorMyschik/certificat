<?php

namespace App\Forms\Admin;

use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrTechnicalReglament;
use Illuminate\Http\Request;

class MrAdminTechnicalReglamentEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $reglament = MrTechnicalReglament::loadBy($args['id']);

    $form['Code'] = array(
      '#type'  => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $reglament ? $reglament->getCode() : null,
    );

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование',
      '#class' => ['mr-border-radius-5'],
      '#value' => $reglament ? $reglament->getName() : null,
    );

    $form['Link'] = array(
      '#type'  => 'textfield',
      '#title' => 'Ссылка',
      '#class' => ['mr-border-radius-5'],
      '#value' => $reglament ? $reglament->getLink() : null,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

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

    $translate = MrTechnicalReglament::loadBy($id) ?: new MrTechnicalReglament();

    $translate->setName($v['Name']);
    $translate->setCode($v['Code']);
    $translate->setLink($v['Link']);

    $translate->save_mr();

    return;
  }
}