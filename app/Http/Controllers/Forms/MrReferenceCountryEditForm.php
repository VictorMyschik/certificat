<?php


namespace App\Http\Controllers\Forms;


use App\Http\Models\MrCountry;
use Illuminate\Http\Request;

class MrReferenceCountryEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);
    $out['id'] = $id;
    $out['country'] = MrCountry::loadBy($id) ?: new MrCountry();
    $out['title'] = $id ? "Редактировать" : 'Создать';

    return View('Form.admin_reference_country_edit_form')->with($out);
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

    $country = MrCountry::loadBy($id) ?: new MrCountry();
    $country->setCode($v['Code']);
    $country->setNameRus($v['NameRus']);
    $country->setNameEng($v['NameEng']);
    $country->save_mr();

    return;
  }
}
