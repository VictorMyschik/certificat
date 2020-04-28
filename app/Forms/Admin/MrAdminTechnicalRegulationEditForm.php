<?php

namespace App\Forms\Admin;

use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrTechnicalRegulation;
use Illuminate\Http\Request;

class MrAdminTechnicalRegulationEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $cert_kind = MrTechnicalRegulation::loadBy($args['id']);

    $form['Code'] = array(
      '#type'  => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getCode() : null,
    );

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getName() : null,
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

    $translate = MrTechnicalRegulation::loadBy($id) ?: new MrTechnicalRegulation();

    $translate->setName($v['Name']);
    $translate->setCode($v['Code']);

    $translate->save_mr();

    return;
  }
}