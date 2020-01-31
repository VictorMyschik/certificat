<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrCountry;
use App\Http\Models\MrOffice;
use Illuminate\Http\Request;

class MrAdminOfficePostDetailsEditForm extends MrFormBase
{
  protected function builderForm(&$form, $office_id)
  {
    $office = MrOffice::loadBy($office_id);

    $form['CountryID'] = array(
      '#type' => 'select',
      '#title' => 'Страна',
      '#default_value' => $office->getCountry() ? $office->getCountry()->id() : 0,
      '#value' => MrCountry::SelectList(),
      '#attributes' => ['style' => 'max-width: 150px;'],
    );

    $form['Email'] = array(
      '#type' => 'textfield',
      '#title' => 'Email',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getEmail() ?: null,
    );

    $form['POPostalCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Индекс',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPOPostalCode() ?: null,
    );

    $form['Phone'] = array(
      '#type' => 'textfield',
      '#title' => 'Телефон',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPhone() ?: null,
    );

    $form['UNP'] = array(
      '#type' => 'textfield',
      '#title' => 'УНП',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getUNP() ?: null,
    );

    $form['PORegion'] = array(
      '#type' => 'textfield',
      '#title' => 'Регион',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPORegion() ?: null,
    );

    $form['POCity'] = array(
      '#type' => 'textfield',
      '#title' => 'Город',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPOCity() ?: null,
    );

    $form['POAddress'] = array(
      '#type' => 'textfield',
      '#title' => 'Адрес',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPOAddress() ?: null,
    );

    $form[] = '<h3>Лицо с правом подписи</h3>';
    $form['PersonFIO'] = array(
      '#type' => 'textfield',
      '#title' => 'ФИО',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPersonFIO() ?: null,
    );

    $form['PersonPost'] = array(
      '#type' => 'textfield',
      '#title' => 'Должность',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPersonPost() ?: null,
    );

    $form['PersonSign'] = array(
      '#type' => 'textfield',
      '#title' => 'Основание',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getPersonSign() ?: null,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if($v['Email'])
    {
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

    $office = MrOffice::loadBy($id) ?: new MrOffice();

    $office->setCountryID($v['CountryID'] ?: null);
    $office->setPhone($v['Phone'] ?: null);
    $office->setPOPostalCode($v['POPostalCode'] ?: null);
    $office->setEmail($v['Email'] ?: null);
    $office->setUNP($v['UNP'] ?: null);
    $office->setPORegion($v['PORegion'] ?: null);
    $office->setPOCity($v['POCity'] ?: null);
    $office->setPOAddress($v['POAddress'] ?: null);
    $office->setPersonFIO($v['PersonFIO'] ?: null);
    $office->setPersonPost($v['PersonPost'] ?: null);
    $office->setPersonSign($v['PersonSign'] ?: null);
    $office->save_mr();


    return;
  }
}