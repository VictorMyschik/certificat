<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrCertificate;
use App\Http\Models\MrCountry;
use Illuminate\Http\Request;

class MrCertificateEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['#title'] = $id ? "Редактирование" : 'Создать';
    $certificate = MrCertificate::loadBy($id);

    $form['Kind'] = array(
      '#type' => 'select',
      '#title' => 'Тип',
      '#default_value' => $certificate ? $certificate->getKind() : 0
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Kind'])
    {
      $out['Kind'] = 'Выберите тип докумета';
    }

    if(!$v['CountryID'])
    {
      $out['CountryID'] = 'Выберите страну';
    }
    else
    {
      if(!MrCountry::loadBy($v['CountryID']))
      {
        $out['CountryID'] = 'Страна не найдена';
      }
    }

    if(!$v['Status'])
    {
      $out['Status'] = 'Выберите статус';
    }

    if(!$v['Number'])
    {
      $out['Number'] = 'Введите номер';
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

    $certificate = MrCertificate::loadBy($id) ?: new MrCertificate();
    $certificate->setKind($v['Kind']);
    $certificate->setCountryID((int)$v['CountryID']);
    $certificate->setDescription($v['Description']);
    $certificate->setNumber($v['Number']);
    $certificate->setLinkOut($v['LinkOut']);
    $certificate->setStatus($v['Status']);
    $certificate->setDateFrom($v['DateFrom']);
    $certificate->setDateTo($v['DateTo']);

    $certificate->save_mr();

    return;
  }
}