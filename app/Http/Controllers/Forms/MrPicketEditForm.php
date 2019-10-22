<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrPickets;
use Illuminate\Http\Request;

class MrPicketEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['picket'] = $picket = MrPickets::loadBy($id) ?: new MrPickets();
    $out['title'] = $id ? "Редактирование пикета №{$picket->id()}" : 'Создать новый пикет';

    return View('Form.admin_pickets_edit_form')->with($out);
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

    $picket = MrPickets::loadBy($id) ?: new MrPickets();
    $code = str_replace(' ', '', $v['Code']);
    $picket->setCode($code);

    $picket->save_mr();

    return;
  }
}