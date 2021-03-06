<?php

namespace App\Forms\FormBase;

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
   * @param string $form_size
   * @return string
   */
  public static function getFormBase($route_name, $data, $btn_name = null, $btn_class = array(), $form_size = 'lg')
  {
    $out = array();

    $out['url'] = route($route_name, $data);
    $out['form_size'] = $form_size;
    $out['btn_name'] = $btn_name ?? 'Изменить';

    $base_class_btn = array();

    foreach ($btn_class as $class)
    {
      $base_class_btn[] = $class;
    }

    $base_class_btn[] = 'mr-border-radius-5';

    $out['btn_class'] = $base_class_btn;

    return View::make('Form.button_form_base')->with($out)->render();
  }

  /**
   * Построение всплывающей формы
   *
   * @return Factory|\Illuminate\View\View
   */
  public function getFormBuilder()
  {
    $route_parameters = Route::getFacadeRoot()->current()->parameters();

    $form = array();
    $form['#title'] = isset(Route::getFacadeRoot()->current()->parameters()['id']) ? __('mr-t.Изменить') : __('mr-t.Создать');
    $this->builderForm($form, $route_parameters);

    // Получение Rout для сохранения
    $route_referer_name = Route::getFacadeRoot()->current()->action['as'];

    $route_submit = explode('_', $route_referer_name);
    $route_submit[count($route_submit) - 1] = 'submit';


    $form['#url'] = route(implode('_', $route_submit), $route_parameters);

    if(!isset($form['#btn_info']))
    {
      $form['#btn_success'] = __('mr-t.Сохранить');
      $form['#btn_cancel'] = __('mr-t.Отменить');
    }

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

  protected static function validateHelper(?string $value, string $field, int $max_langth, array &$errors): array
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

  protected static function allRequestNeed(&$out, array $v)
  {
    foreach ($v as $key => $item)
    {
      if(!$item)
      {
        $out[$key] = "Не заполнено поле {$key}";
      }
    }
  }
}