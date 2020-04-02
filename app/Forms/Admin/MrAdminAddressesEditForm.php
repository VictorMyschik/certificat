<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrAddresses;
use App\Models\MrCountry;
use Illuminate\Http\Request;

class MrAdminAddressesEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id, $args)
  {
    $form['#title'] = $args['id'] ? "Редактирование" : 'Создать';


    $address = MrAddresses::loadBy($args['id']);

    $form['CountryID'] = array(
      '#type' => 'select',
      '#title' => 'Страна',
      '#default_value' => $address ? $address->getCountry()->id() : $args['country_id'],
      '#value' => MrCountry::getSelectList(),
    );

    $form['City'] = array(
      '#type' => 'textfield',
      '#title' => 'Город',
      '#value' => $address ? $address->getCity() : null,
      '#attributes' => ['maxlength' => 255],
    );

    $form['Building'] = array(
      '#type' => 'textfield',
      '#title' => 'Здание, культ. ценность',
      '#value' => $address ? $address->getBuilding() : null,
      '#attributes' => ['maxlength' => 255],
    );

    $form['Address'] = array(
      '#type' => 'textfield',
      '#title' => 'Точный адрес',
      '#value' => $address ? $address->getAddress() : null,
      '#attributes' => ['maxlength' => 255],
    );

    $form['Lat'] = array(
      '#type' => 'textfield',
      '#title' => 'Широта',
      '#value' => $address ? $address->getLat() : null,
      '#attributes' => ['maxlength' => 50],
    );

    $form['Lon'] = array(
      '#type' => 'textfield',
      '#title' => 'Долгота',
      '#value' => $address ? $address->getLon() : null,
      '#attributes' => ['maxlength' => 50],
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

    $errors = self::validateForm($v);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $address = MrAddresses::loadBy($id) ?: new MrAddresses();

    $address->setCity($v['City']);
    $address->setBuilding($v['Building']);
    $address->setAddress($v['Address']);
    $address->setLat($v['Lat']);
    $address->setLon($v['Lon']);
    $address->setCountryID($v['CountryID']);
    $address->save_mr();

    return;
  }
}
