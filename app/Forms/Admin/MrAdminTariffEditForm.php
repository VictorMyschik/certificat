<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Helpers\MrMessageHelper;
use App\Models\MrTariff;
use Illuminate\Http\Request;

class MrAdminTariffEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $tariff = MrTariff::loadBy($id);

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование тарифа',
      '#class' => ['mr-border-radius-5'],
      '#value' => $tariff ? $tariff->getName() : null,
    );

    $form['Category'] = array(
      '#type' => 'select',
      '#title' => 'Категория',
      '#default_value' => 0,
      '#value' => MrTariff::getCategoryList(),
    );

    $form['Measure'] = array(
      '#type' => 'select',
      '#title' => 'За что оплата',
      '#default_value' => $tariff ? $tariff->getMeasure() : 0,
      '#value' => MrTariff::getMeasureList(),
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

    if(!$v['Cost'])
    {
      $out['Cost'] = 'Стоимость обязательна';
    }
    if(!$v['Name'])
    {
      $out['Name'] = 'Наименование тарифа обязательно';
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

    parent::submitFormBase($request->all());

    $tariff = MrTariff::loadBy($id) ?: new MrTariff();
    $tariff->setName($v['Name']);
    $tariff->setDescription($v['Description']);
    $tariff->setCost($v['Cost']);
    $tariff->setMeasure($v['Measure']);
    $tariff->setCategory($v['Category']);
    $tariff->save_mr();

    MrMessageHelper::SetMessage(true, "Тариф {$v['Name']} успешно создан");

    return;
  }
}