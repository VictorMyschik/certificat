<?php


namespace App\Forms;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrAddresses;

class MrMapPopupInfoForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $address = MrAddresses::loadBy($id);
    $form['#title'] = '';
    $form[] = $address->GetFullAddress();
    $form[] = View('layouts.Elements.google_map')->with(['lat' => $address->getLat(), 'lon' => $address->getLon()]);

    $form['#btn_info'] = 'Close';

    return $form;
  }
}