<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Forms\FormBase\MrFormBase;
use App\Models\MrLanguage;
use Illuminate\Http\Request;

class MrAdminLanguageEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $form['#title'] = $id ? "Редактирование" : 'Создать';

    $language = MrLanguage::loadBy($id);

    $form['Delete'] = array(
      '#type' => 'checkbox',
      '#title' => 'Удалить',
      '#value' => true,
      '#attributes' => [],
    );

    $form['LanguageID'] = array(
      '#type' => 'select',
      '#title' => 'Язык',
      '#default_value' => $language ? $language->id() : 0,
      '#value' => MrLanguage::SelectList(),
    );

    $form['Name'] = array(
      '#type' => 'textfield',
      '#title' => 'Код',
      '#class' => ['mr-border-radius-5'],
      '#value' => $language ? $language->getName() : null,
    );

    $form['Description'] = array(
      '#type' => 'textfield',
      '#title' => 'Примечание (для себя)',
      '#class' => ['mr-border-radius-5'],
      '#value' => $language ? $language->getDescription() : null,
    );


    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['LanguageID'])
    {
      if(MrLanguage::loadBy($v['Name'], 'Name'))
      {
        $out['Name'] = 'Такой язык уже существует';
      }
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

    $language = MrLanguage::loadBy($v['LanguageID']) ?: new MrLanguage();

    if(isset($v['Delete']) && $v['Delete'])
    {
      $language->mr_delete();
    }
    else
    {
      $language->setName($v['Name']);
      $language->setDescription($v['Description'] ?: null);
      $language->save_mr();
    }


    return;
  }
}