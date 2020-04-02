<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrCertificate;
use App\Models\MrCountry;
use Illuminate\Http\Request;

class MrAdminCertificateEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['#title'] = $id ? "Редактирование" : 'Создать';

    $certificate = MrCertificate::loadBy($id);

    $form['Kind'] = array(
      '#type' => 'select',
      '#title' => 'Тип',
      '#default_value' => $certificate ? $certificate->getKind() : 0,
      '#value' => MrCertificate::getKinds(),
    );

    $form['Number'] = array(
      '#type' => 'textfield',
      '#title' => 'Номер',
      '#value' => $certificate ? $certificate->getNumber() : null,
    );

    $form['DateFrom'] = array(
      '#type' => 'date',
      '#title' => 'Дата с',
      '#value' => $certificate ? $certificate->getDateFrom()->getMysqlDate() : null,
    );

    $form['DateTo'] = array(
      '#type' => 'date',
      '#title' => 'Дата по',
      '#value' => $certificate ? $certificate->getDateTo()->getMysqlDate() : null,
    );

    $form['CountryID'] = array(
      '#type' => 'select',
      '#title' => 'Страна',
      '#default_value' => $certificate ? $certificate->getCountry()->id() : 0,
      '#value' => MrCountry::SelectList(),
    );

    $form['Status'] = array(
      '#type' => 'select',
      '#title' => 'Статус',
      '#default_value' => $certificate ? $certificate->getStatus() : 0,
      '#value' => MrCertificate::getStatuses(),
    );

    $form['LinkOut'] = array(
      '#type' => 'textfield',
      '#title' => 'Ссылка',
      '#value' => $certificate ? $certificate->getLinkOut() : null,
    );

    $form['Description'] = array(
      '#type' => 'textfield',
      '#title' => 'Примечание',
      '#value' => $certificate ? $certificate->getDescription() : null,
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