<?php


namespace App\Forms;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrOffice;
use App\Models\MrTariff;
use App\Models\MrTariffInOffice;
use Illuminate\Http\Request;

class MrOfficeTariffEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['TariffID'] = array(
      '#type' => 'select',
      '#title' => 'Тарифы',
      '#value' => MrTariff::SelectList(),
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

    $office = MrOffice::loadBy($id);

    $tio = new MrTariffInOffice();
    $tio->setOfficeID($office->id());
    $tio->setTariffID($v['TariffID']);

    $tio->save_mr();

    return;
  }
}