<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Models\MrLanguage;
use App\Models\MrTranslate;
use Illuminate\Http\Request;

class MrTranslateWordEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['word'] = $word = MrTranslate::loadBy($id) ?: new MrTranslate();
    $out['title'] = $id ? "Редактирование {$word->getName()}" : 'Создать';
    $out['languages'] = MrLanguage::GetAll();

    return View('Form.admin_translate_word_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['LanguageID'])
    {
      $out['LanguageID'] = 'Выберите язык';
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

    $translate = MrTranslate::loadBy($id) ?: new MrTranslate();
    $translate->setName($v['Name']);
    $translate->setTranslate($v['Translated']);
    $translate->setLanguageID($v['LanguageID']);
    $translate->save_mr();

    return;
  }
}