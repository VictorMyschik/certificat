<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\References\MrCurrency;
use Illuminate\Http\Request;

class MrAdminReferenceCurrencyEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $currency = MrCurrency::loadBy($args['id']);

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование',
      '#value' => $currency ? $currency->getName() : null,
    );

    $form['TextCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Текстовый код',
      '#value' => $currency ? $currency->getTextCode() : null,
    );

    $form['Code'] = array(
      '#type' => 'textfield',
      '#title' => 'Цифровой код',
      '#value' => $currency ? $currency->getCode() : null,
    );

    $form['DateFrom'] = array(
      '#type' => 'date',
      '#title' => 'Дата с',
      '#value' => $currency ? ($currency->getDateFrom() ? $currency->getDateFrom()->getMysqlDate() : null) : null,
    );

    $form['DateTo'] = array(
      '#type' => 'date',
      '#title' => 'Дата по',
      '#value' => $currency ? ($currency->getDateTo() ? $currency->getDateTo()->getMysqlDate() : null) : null,
    );


    $form['Rounding'] = array(
      '#type' => 'textfield',
      '#title' => 'Округление',
      '#value' => $currency ? $currency->getRounding() : null,
    );

    $form['Description'] = array(
      '#type' => 'textfield',
      '#title' => 'Примечание',
      '#value' => $currency ? $currency->getDescription() : null,
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

    parent::submitFormBase($v);

    $object = MrCurrency::loadBy($v['Code'], 'Code') ?: new MrCurrency();

    $object->setCode($v['Code']);
    $object->setTextCode($v['TextCode']);
    $object->setName($v['Name']);
    $object->setRounding($v['Rounding']);
    $object->setDescription($v['Description']);
    $object->setDateFrom($v['DateFrom']);
    $object->setDateTo($v['DateTo']);
    $object->save_mr();

    return;
  }
}
