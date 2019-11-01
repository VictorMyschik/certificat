<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrCountry;
use Illuminate\Http\Request;

class MrReferenceCountryEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['#title'] = $id ? "Редактирование" : 'Создать';
    $country = MrCountry::loadBy($id);

    $form['NameRus'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование',
      '#value' => $country ? $country->getNameEng() : null,
    );

    $form['NameEng'] = array(
      '#type' => 'textfield',
      '#title' => 'На английском',
      '#value' => $country ? $country->getNameEng() : null,
    );

    $form['Code'] = array(
      '#type' => 'textfield',
      '#title' => 'Буквенный код',
      '#value' => $country ? $country->getCode() : null,
    );

    $form['NumericCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Цифровой код',
      '#value' => $country ? $country->getNumericCode() : null,
    );

    return $form;
  }


  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);
    if(!$v['Code'])
    {
      $out['Code'] = 'Буквенный код обязателен';
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();

    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $country = MrCountry::loadBy($id) ?: new MrCountry();
    $country->setCode($v['Code']);
    $country->setNumericCode($v['NumericCode'] ?: null);
    $country->setNameRus($v['NameRus']);
    $country->setNameEng($v['NameEng']);
    $country->save_mr();

    return;
  }
}
