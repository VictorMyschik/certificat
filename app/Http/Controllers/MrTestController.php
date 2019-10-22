<?php

namespace App\Http\Controllers;


use App\Models\MrParticipant;
use Illuminate\Support\Facades\DB;

class MrTestController extends Controller
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
    $out = array();
    $user_id = 54;
    $text = 'Пользователь был удалён';
    if(false)
    {
      $arr = array(
        'UserID' => 1,//MrUser::zeroUser()->id(),
      );
    }
    else
    {
      $arr = array(
        'UserID' => 1,//MrUser::zeroUser()->id(),
        'FirstName' => $text,
        'LastName' => '',
        'Passport' => '',
        'Phone' => '',
      );
    }

    DB::table(MrParticipant::$mr_table)->Where('UserID', '=', $user_id)->update($arr);
    return View('test')->with($out);
  }

}