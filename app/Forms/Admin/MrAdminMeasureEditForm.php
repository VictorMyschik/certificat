<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrMeasure;
use Illuminate\Http\Request;

class MrAdminMeasureEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $measure = MrMeasure::loadBy($args['id']);

    $form['Code'] = array(
      '#type'  => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $measure ? $measure->getCode() : null,
    );

    $form['TextCode'] = array(
      '#type'  => 'textfield',
      '#title' => 'Условное обозначение',
      '#class' => ['mr-border-radius-5'],
      '#value' => $measure ? $measure->getTextCode() : null,
    );

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование',
      '#class' => ['mr-border-radius-5'],
      '#value' => $measure ? $measure->getName() : null,
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

    $translate = MrMeasure::loadBy($id) ?: new MrMeasure();
    $translate->setName($v['Name']);
    $translate->setCode($v['Code']);
    $translate->setTextCode($v['TextCode']);

    $translate->save_mr();

    return;
  }
}