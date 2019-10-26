<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;

class MrForm extends Controller
{
  public static function loadForm(string $route_name, string $class_name, array $data, $btn_name = null, $btn_class = array())
  {
    $object = "App\\Http\\Controllers\\Forms\\" . $class_name;

    return $object::getFormBase($route_name, $data, $btn_name, $btn_class);
  }

  /**
   * Список обязательных полей
   * $fields = count 0 - все обязательны
   *
   * @param array $request - Request
   * @param array $fields
   * @return array
   */
  public static function required(array $request, array $fields = array()): array
  {
    $errors = array();
    unset($request['_token']);

    if(count($fields))
    {
      foreach ($fields as $key => $item)
      {
        if(!$request[$key] || ($request[$key] == '') || ($request[$key] == '0'))
        {
          $errors[$key] = 'Поле ' . $item . ' не заполнено';
        }
      }
    }
    else
    {
      foreach ($request as $key)
      {
        if(($key == '') || ($key == '0'))
        {
          $errors[0] = 'Заполните все поля';
        }
      }
    }

    if(count($errors))
    {
      $out = implode('<br>', $errors);
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, $out);
    }

    return $errors;
  }
}