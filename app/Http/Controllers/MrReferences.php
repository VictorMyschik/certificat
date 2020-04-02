<?php


namespace App\Http\Controllers;


use App\Helpers\MrMessageHelper;

class MrReferences extends Controller
{
  protected $references = array(
    'country' => 'Страны мира',
  );


  public function List()
  {
    $out = array();

    $out['list'] = $this->references;

    return View('References.list')->with($out);
  }

  public function View(string $name)
  {
    $out = array();

    if(isset($this->references[$name]) && ($reference = $this->references[$name]))
    {
      $out['reference_name'] = __('mr-t.' . $reference);

      $pref = 'Mr';
      $l = substr($name, 0, 1);
      $class_name = str_replace($l, mb_strtoupper($l), $name);
      $class_name = "App\\Models\\" . $pref . $class_name;

      if(class_exists($class_name))
      {
        $out['list'] = $class_name::GetAll();
        return View('References.' . $name)->with($out);
      }
      else
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, __('mr-t.Справочник не найден'));
        return back();
      }

      return View('References.' . $name)->with($out);
    }

    abort('404', __('mr-t.Справочник не найден'));
  }
}