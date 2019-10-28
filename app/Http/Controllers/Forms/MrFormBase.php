<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class MrFormBase extends Controller
{
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

  protected static function getFormBuilder(&$out)
  {
    $out['btn_success'] = 'Сохранить';
    $out['btn_cancel'] = 'Отменить';
    $out['title'] = '';

    return $out;
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