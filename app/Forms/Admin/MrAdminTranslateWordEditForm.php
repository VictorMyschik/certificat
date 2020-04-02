<?php


namespace App\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrLanguage;
use App\Models\MrTranslate;
use Illuminate\Http\Request;

class MrAdminTranslateWordEditForm extends MrFormBase
{
  protected function builderForm(&$form, $args)
  {
    $word = MrTranslate::loadBy($args['id']);

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Руский',
      '#class' => ['mr-border-radius-5'],
      '#value' => $word ? $word->getName() : null,
    );

    $form['LanguageID'] = array(
      '#type' => 'select',
      '#title' => 'Язык',
      '#default_value' => $word ? $word->getLanguage()->id() : 0,
      '#value' => MrLanguage::SelectList(),
    );

    $form['Translated'] = array(
      '#type' => 'textfield',
      '#title' => 'Перевод',
      '#class' => ['mr-border-radius-5'],
      '#value' => $word ? $word->getTranslate() : null,
    );


    return $form;
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
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $translate = MrTranslate::loadBy($id) ?: new MrTranslate();
    $translate->setName($v['Name']);
    $translate->setTranslate($v['Translated']);
    $translate->setLanguageID($v['LanguageID']);
    $translate->save_mr();

    return;
  }
}