<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrTariff;
use Illuminate\Http\Request;

class MrAdminTariffEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    $tariff = MrTariff::loadBy($id);
    $out = array();

    $out['id'] = $id;
    $out['tariff'] = $tariff;
    $out['Category'] = array(
      '#type' => 'select',
      '#title' => 'Категория',
      '#default' => 0,
      '#value' => MrTariff::getCategoryList(),
    );

    $out['Measure'] = array(
      '#type' => 'textfield',
      '#default' => $tariff ? $tariff->getMeasure() : null,
      '#title' => 'За что оплата',
    );

    $out['title'] = $id ? "Редактирование" : 'Создать';

   return parent::getFormBuilder($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Field'] || !$v['Value'])
    {
      $out['Field'] = 'Заполните "Поле"';
      $out['Value'] = 'Заполните "Значение"';
    }


    return $out;
  }

  protected static function submitForm(Request $request, int $certificate_id, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['CertificateID' => $certificate_id, 'id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());


    return;
  }
}