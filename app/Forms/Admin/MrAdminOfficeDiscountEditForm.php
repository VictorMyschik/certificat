<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Models\MrDiscount;
use App\Models\MrOffice;
use Illuminate\Http\Request;

class MrAdminOfficeDiscountEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id, $data = array())
  {
    $discount = MrDiscount::loadBy($id);
    $office = MrOffice::loadBy($data['office_id']);
    $tariff = null;

    if($discount && $discount->getTariff())
    {
      $tariff = $discount->getTariff()->id();
    }

    $tariffs = array();
    $tariffs[0] = 'Для всего ВО';
    foreach ($office->GetTariffs() as $q)
    {
      $tariffs[$q->getTariff()->id()] = $q->getTariff()->getName();
    }

    $form['TariffID'] = array(
      '#type' => 'select',
      '#title' => 'Тариф',
      '#default_value' => $tariff ?: 0,
      '#value' => $tariffs
    );

    $form['DateFrom'] = array(
      '#type' => 'date',
      '#title' => 'Дата С',
      '#value' => $discount ? $discount->getDateFrom()->getMysqlDate() : null,
    );

    $form['DateTo'] = array(
      '#type' => 'date',
      '#title' => 'Дата По',
      '#value' => $discount ? $discount->getDateTo()->getMysqlDate() : null,
    );

    $form['Kind'] = array(
      '#type' => 'select',
      '#title' => 'Тип скидки',
      '#default_value' => $discount ? $discount->getKind() : 0,
      '#value' => MrDiscount::getKinds(),
    );

    $form['Amount'] = array(
      '#type' => 'number',
      '#title' => 'Размер',
      '#class' => ['mr-border-radius-5'],
      '#value' => $discount ? $discount->getAmount() : null,
    );


    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['DateFrom'])
    {
      $out['DateFrom'] = 'Срок действия скидки обязтелен';
    }

    if(!$v['DateTo'])
    {
      $out['DateTo'] = 'Срок действия скидки обязтелен';
    }


    return $out;
  }

  protected static function submitForm(Request $request, int $office_id, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($v);

    $office = MrOffice::loadBy($office_id);

    $tariff = MrDiscount::loadBy($id) ?: new MrDiscount();
    $tariff->setOfficeID($office->id());
    $tariff->setTariffID($v['TariffID'] ?: null);
    $tariff->setAmount($v['Amount']);
    $tariff->setKind($v['Kind']);
    $tariff->setDateFrom($v['DateFrom']);
    $tariff->setDateTo($v['DateTo']);
    $tariff->save_mr();

    $r = $id ? 'изменена' : 'добавлена';
    $message = "Скидка для {$office->getName()} успешно {$r}";

    MrMessageHelper::SetMessage(true, $message);

    return;
  }
}