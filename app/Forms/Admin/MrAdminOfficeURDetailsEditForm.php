<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrOffice;
use Illuminate\Http\Request;

class MrAdminOfficeURDetailsEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $office = MrOffice::loadBy($id);
    $form[] = '<h3>Юредические данные</h3>';
    $form['URPostalCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Индекс',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getURPostalCode() ?: null,
    );

    $form['URRegion'] = array(
      '#type' => 'textfield',
      '#title' => 'Регион',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getURRegion() ?: null,
    );

    $form['URCity'] = array(
      '#type' => 'textfield',
      '#title' => 'Город',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getURCity() ?: null,
    );

    $form['URAddress'] = array(
      '#type' => 'textfield',
      '#title' => 'Адрес',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getURAddress() ?: null,
    );

    $form[] = '<h3 class="margin-t-10">Банковские реквизиты</h3>';

    $form['BankName'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование банка',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getBankName() ?: null,
    );

    $form['BankAddress'] = array(
      '#type' => 'textfield',
      '#title' => 'Адрес банка',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getBankAddress() ?: null,
    );

    $form['BankRS'] = array(
      '#type' => 'textfield',
      '#title' => 'р/с',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getBankRS() ?: null,
    );

    $form['BankCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Код банка',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getBankCode() ?: null,
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

    $office = MrOffice::loadBy($id) ?: new MrOffice();

    $office->setURPostalCode($v['URPostalCode'] ?: null);
    $office->setURRegion($v['URRegion'] ?: null);
    $office->setURCity($v['URCity'] ?: null);
    $office->setURAddress($v['URAddress'] ?: null);
    $office->setBankName($v['BankName'] ?: null);
    $office->setBankRS($v['BankRS'] ?: null);
    $office->setBankAddress($v['BankAddress'] ?: null);
    $office->setBankCode($v['BankCode'] ?: null);
    $office->save_mr();


    return;
  }
}