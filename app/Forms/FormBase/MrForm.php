<?php


namespace App\Http\Controllers\Forms\FormBase;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class MrForm extends Controller
{
  public static function loadForm(string $route_name, array $data, $btn_name = null, $btn_class = array(), string $form_size = 'lg')
  {
    $action = null;
    foreach (Route::getRoutes() as $route)
    {
      if(isset($route->action['as']) && $route->action['as'] == 'office_discount_edit')
      {
        $action = $route->action['controller'];
      }
    }

    $object = substr($action, 0, strpos($action, '@'));

    return $object::getFormBase($route_name, $data, $btn_name, $btn_class, $form_size);
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
      MrMessageHelper::SetMessage(false, $out);
    }

    return $errors;
  }
}