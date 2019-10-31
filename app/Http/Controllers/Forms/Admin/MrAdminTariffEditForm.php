<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrTariff;
use Illuminate\Http\Request;

class MrAdminTariffEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $tariff = MrTariff::loadBy($id);

    $form['#title'] = $id ? "Редактирование" : 'Создать';

    $form['#id'] = $id;

    $form['Category'] = array(
      '#type' => 'select',
      '#title' => 'Категория',
      '#default_value' => 0,
      '#value' => MrTariff::getCategoryList(),
    );

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование тарифа',
      '#class' => ['mr-border-radius-5'],
      '#value' => $tariff ? $tariff->getName() : null,
    );

    $form['Measure'] = array(
      '#type' => 'textfield',
      '#title' => 'За что оплата',
      '#class' => ['mr-border-radius-5'],
      '#value' => $tariff ? $tariff->getMeasure() : null,
    );

    $form['Cost'] = array(
      '#type' => 'number',
      '#title' => 'Цена',
      '#class' => ['mr-border-radius-5'],
      '#value' => $tariff ? $tariff->getCost() : null,
    );

    $form['Description'] = array(
      '#type' => 'textfield',
      '#title' => 'Примечание для себя',
      '#class' => ['mr-border-radius-5'],
      '#value' => $tariff ? $tariff->getDescription() : null,
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
    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $tariff = MrTariff::loadBy($id) ?: new MrTariff();
    $tariff->setName($v['Name']);
    $tariff->setDescription($v['Description']);
    $tariff->setCost($v['Cost']);
    $tariff->setMeasure($v['Measure']);
    $tariff->setCategory($v['Category']);
    $tariff->save_mr();

    return;
  }
}