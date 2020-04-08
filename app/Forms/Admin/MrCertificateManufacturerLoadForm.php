<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use Illuminate\Http\Request;

class MrCertificateManufacturerLoadForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $form['File'] = array(
      '#type' => 'file',
      '#title' => '1',
      '#value' => '',
    );

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => '213123',
      '#value' => '213123',

    );
  }

  protected static function validateForm($request)
  {


  }

  protected static function submitForm(Request $request)
  {
    //$errors['File'] = 'qwqe';
    $errors = array();

    $errors['Name'] = implode(' | ', $request->all());

    if(count($errors))
    {
      return $errors;
    }


    return;
  }
}