<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrCertificate;
use App\Http\Models\MrCertificateDetails;
use Illuminate\Http\Request;

class MrCertificateDetailsEditForm extends MrFormBase
{
  protected static function builderForm(int $certificate_id, int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['certificate_details'] = MrCertificateDetails::loadBy($id);
    $out['certificate'] = MrCertificate::loadBy($certificate_id);
    $out['title'] = $id ? "Редактирование" : 'Создать';

    return View('Form.admin_certificate_details_edit_form')->with($out);
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