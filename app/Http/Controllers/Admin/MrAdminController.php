<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MtStringUtils;
use App\Models\MrUser;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Redis;

class MrAdminController extends Controller
{
  public function index()
  {
    if(!MrUser::me()->IsSuperAdmin())
    {
      return back();
    }

    $out = array();

    $data = new Redis();
    $data->connect('localhost');

    $redis_info = $data->info();
    $data->select(3);

    $out['Redis'] = array(
      'used_memory' => MtStringUtils::formatSize($redis_info['used_memory']),
      'max_memory' => MtStringUtils::formatSize($redis_info['maxmemory']),
      'dbSize' =>($data->dbSize()),
    );

    //$out['visits'] = MrLogIdent::GetDifferentUsers($date);

    return View('Admin.mir_admin')->with($out);
  }


  /**
   * Удаление пользователя навсегда из БД
   *
   * @param int $id
   * @return RedirectResponse
   * @throws \Exception
   */
  public function userDeleteForever(int $id)
  {
    if($user = MrUser::loadBy($id))
    {
      $user_laravel = $user->getUserLaravel();
      $user->mr_delete();

      User::find($user_laravel->id)->delete();
    }

    return Redirect::route('users');
  }
}