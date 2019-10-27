<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MrMessageHelper;

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
    $pref = 'Mr';
    if($reference = $this->references[$name])
    {
      $l = substr($reference, 0, 1);
      $class_name = str_replace($l, mb_strtoupper($l), $reference);
      $class_name = $pref . $class_name;

      if(class_exists($class_name))
      {
        $out['list'] = $class_name::GetAll();
        return View('References.' . $name)->with($out);
      }
      else
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Справочника нет');
        return back();
      }
    }
  }
}