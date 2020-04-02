<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrCertificate;
use App\Models\MrCertificateDetails;
use Illuminate\Http\Request;

class MrAdminCertificateDetailsEditForm extends MrFormBase
{
  protected function builderForm(&$form, $certificate_id, $id)
  {
    $certificate = MrCertificate::loadBy($certificate_id);

    $form['#title'] = $id ? "Редактирование" : 'Создать';

    $form['Kind'] = array(
      '#type' => 'select',
      '#title' => 'Тип',
      '#default_value' => 0,
      '#value' => MrCertificate::getKinds(),
    );


    return $form;
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


    $certificate = MrCertificateDetails::loadBy($id) ?: new MrCertificateDetails();
    $certificate->setCertificateID($certificate_id);
    $certificate->setField($v['Field']);
    $certificate->setValue($v['Value']);

    $certificate->save_mr();

    return;
  }
}