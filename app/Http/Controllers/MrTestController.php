<?php

namespace App\Http\Controllers;



use App\Models\MrCountry;

class MrTestController extends Controller
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
    MrCountry::loadBy(1);
    $out = array();
    $data = json_decode(file_get_contents('http://api.travelpayouts.com/data/ru/countries.json'));
    foreach ($data as $item)
    {
      $new = new MrCountry();
      $new->setCode($item['code']);
      $new->setNameRus($item['name']);
      $new->setNameEng($item['name_translations']['en']);

      $new->save_mr();
    }


    return View('test')->with($out);
  }

}