<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Models\MrAddresses;

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