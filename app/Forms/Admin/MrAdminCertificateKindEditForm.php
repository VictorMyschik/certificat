<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrCertificateKind;
use Illuminate\Http\Request;

class MrAdminCertificateKindEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $cert_kind = MrCertificateKind::loadBy($args['id']);

    $form['Code'] = array(
      '#type'  => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getCode() : null,
    );

    $form['ShortName'] = array(
      '#type'  => 'textfield',
      '#title' => 'Условное обозначение',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getShortName() : null,
    );

    $form['Name'] = array(
      '#type'  => 'textfield',
      '#title' => 'Наименование',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getName() : null,
    );

    $form['Description'] = array(
      '#type'  => 'textarea',
      '#title' => 'Примечание',
      '#class' => ['mr-border-radius-5'],
      '#value' => $cert_kind ? $cert_kind->getDescription() : null,
      '#rows'  => 5,
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

    $translate = MrCertificateKind::loadBy($id) ?: new MrCertificateKind();

    $translate->setName($v['Name']);
    $translate->setCode($v['Code']);
    $translate->setShortName($v['ShortName']);
    $translate->setDescription($v['Description'] ?: null);

    $translate->save_mr();

    return;
  }
}