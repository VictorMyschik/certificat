<?php


namespace App\Http\Controllers\Forms;


use App\Http\Controllers\Controller;

class MrForm extends Controller
{
  public static function loadForm(string $route_name, string $class_name, array $data, $btn_name = null, $btn_class = array())
  {
    $object = "App\\Http\\Controllers\\Forms\\" . $class_name;

    return $object::getFormBase($route_name, $data, $btn_name, $btn_class);
  }
}