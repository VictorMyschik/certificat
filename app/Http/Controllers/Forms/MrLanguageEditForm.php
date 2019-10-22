<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrLanguage;
use Illuminate\Http\Request;

class MrLanguageEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['language'] = MrLanguage::loadBy($id) ?: new MrLanguage();
    $out['title'] = $id ? "Редактирование" : 'Создать';
    $out['languages'] = MrLanguage::GetAll();

    return View('Form.admin_language_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['id'])
    {
      if(!$v['Name'])
        $out['Name'] = 'Поле имя обязательно для заполнения';

      if(MrLanguage::loadBy($v['Name'], 'Name'))
        $out['Name'] = 'Такой язык уже существует';
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
      return $errors;

    parent::submitFormBase($request->all());

    $language = MrLanguage::loadBy($v['id']) ?: new MrLanguage();

    if($language->id)
    {
      if($v['option'] == 2)
      {
        $language->mr_delete();
      }
      else
      {
        if($v['Name'])
          $language->setName($v['Name']);
        if($v['Description'])
          $language->setDescription($v['Description']);
        $language->save_mr();
      }
    }
    else
    {
      $language->setName($v['Name']);
      $language->setDescription($v['Description']);
      $language->save_mr();
    }


    return;
  }
}