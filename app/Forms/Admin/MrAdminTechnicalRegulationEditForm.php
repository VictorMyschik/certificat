<?php

namespace App\Forms\Admin;

use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrTechnicalRegulation;
use Illuminate\Http\Request;

class MrAdminTechnicalRegulationEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $regulation = MrTechnicalRegulation::loadBy($args['id']);

    $form['Code'] = array(
      '#type'  => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $regulation ? $regulation->getCode() : null,
    );

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование',
      '#class' => ['mr-border-radius-5'],
      '#value' => $regulation ? $regulation->getName() : null,
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

    $regulation = MrTechnicalRegulation::loadBy($id) ?: new MrTechnicalRegulation();

    $regulation->setName($v['Name']);
    $regulation->setCode($v['Code']);

    $regulation->save_mr();

    return;
  }
}