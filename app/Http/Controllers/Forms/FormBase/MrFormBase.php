<?php


namespace App\Http\Controllers\Forms\FormBase;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class MrFormBase extends Controller
{
  /**
   * Построение кнопки вызова формы
   *
   * @param $route_name
   * @param $data
   * @param null $btn_name
   * @param array $btn_class
   * @return \Illuminate\Contracts\View\View
   */
  public static function getFormBase($route_name, $data, $btn_name = null, $btn_class = array())
  {
    $out = array();

    $url_data = array();
    foreach ($data as $key => $item)
    {
      $url_data[$key] = $item;
    }

    $out['url'] = route($route_name, $url_data);
    $out['btn_name'] = $btn_name ?? 'Изменить';
    $base_class_btn = array(
      'mr-border-radius-5'
    );

    foreach ($btn_class as $class)
    {
      $base_class_btn[] = $class;
    }

    $out['btn_class'] = $base_class_btn;

    return View::make('Form.button_form_base')->with($out);
  }

  /**
   * Построение всплывающей формы
   *
   * @param int $id
   * @return Factory|\Illuminate\View\View
   */
  public function getFormBuilder(int $id)
  {
    $form = array();
    $this->builderForm($form, $id);

    // Получеине роута для сохранения
    $route_referer_name = Route::getFacadeRoot()->current()->action['as'];
    $route_submit = explode('_', $route_referer_name);
    $route_submit[count($route_submit) - 1] = 'submit';

    $form['#url'] = route(implode($route_submit, '_'), ['id' => $id]);

    $form['#btn_success'] = 'Сохранить';
    $form['#btn_cancel'] = 'Отменить';
    $out['form'] = $form;

    return View('Form.BaseForm.form_templates')->with($out);
  }

  protected static function ValidateBase(&$out, array $v)
  {
    $out = array();


    return $out;
  }

  protected static function submitFormBase($v)
  {


  }

  protected static function validateHalper(?string $value, string $field, int $max_langth, array &$errors): array
  {
    if($value)
    {
      if(strlen($value) > $max_langth)
      {
        $errors[$field] = 'Поле ' . $field . ' не должно превышать ' . $max_langth . ' символов.';
      }
    }

    return $errors;
  }
}