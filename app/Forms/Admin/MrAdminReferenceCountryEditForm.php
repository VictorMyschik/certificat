<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrCountry;
use Illuminate\Http\Request;

class MrAdminReferenceCountryEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $country = MrCountry::loadBy($args['id']);

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Наименование',
      '#value' => $country ? $country->getName() : null,
      '#attributes' => ['maxlength' => 50],
    );

    $form['ISO3166alpha2'] = array(
      '#type' => 'textfield',
      '#title' => 'ISO-3166 alpha2',
      '#value' => $country ? $country->getISO3166alpha2() : null,
      '#attributes' => ['maxlength' => 3],
    );

    $form['ISO3166alpha3'] = array(
      '#type' => 'textfield',
      '#title' => 'ISO-3166 alpha3',
      '#value' => $country ? $country->getISO3166alpha3() : null,
      '#attributes' => ['maxlength' => 3],
    );

    $form['ISO3166numeric'] = array(
      '#type' => 'textfield',
      '#title' => 'ISO-3166 numeric',
      '#value' => $country ? $country->getISO3166numeric() : null,
      '#attributes' => ['maxlength' => 3],
    );

    $form['Capital'] = array(
      '#type' => 'textfield',
      '#title' => 'Столица',
      '#value' => $country ? $country->getCapital() : null,
      '#attributes' => ['maxlength' => 50],
    );

    $form['Continent'] = array(
      '#type' => 'select',
      '#title' => 'Континент',
      '#default_value' => $country ? $country->getContinent() : 0,
      '#value' => MrCountry::getContinentList(),
    );

    return $form;
  }


  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);
    parent::allRequestNeed($out, $v);

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

    $country = MrCountry::loadBy($id) ?: new MrCountry();

    $country->setName($v['Name']);
    $country->setISO3166alpha2($v['ISO3166alpha2']);
    $country->setISO3166alpha3($v['ISO3166alpha3'] ?: null);
    $country->setISO3166numeric($v['ISO3166numeric']);
    $country->setCapital($v['Capital']);
    $country->setContinent($v['Continent']);
    $country->save_mr();

    return;
  }
}
