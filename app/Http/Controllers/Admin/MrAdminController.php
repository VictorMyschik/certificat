<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MrStringUtils;
use App\Http\Controllers\Controller;
use App\Models\MrUser;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Redis;

class MrAdminController extends Controller
{
  public function index()
  {
    $out = array();

    return View('Admin.mir_admin')->with($out);
  }

  /**
   * Получение данных по нагрузке на сайт
   */
  public function GetData()
  {
    if(!MrUser::me()->IsSuperAdmin())
    {
      return back();
    }


    $data = new Redis();
    $data->connect('localhost');

    $redis_info = $data->info();
    $data->select(4);

    return array(
      ['Title' => 'Пользователей', 'Value' => MrUser::count()],
      ['Title' => 'Used Memory', 'Value' => MrStringUtils::formatSize($redis_info['used_memory'])],
      ['Title' => 'Max Memory', 'Value' => MrStringUtils::formatSize($redis_info['maxmemory'])],
      ['Title' => 'Количество объектов Redis', 'Value' => $data->dbSize()],
    );
  }

  /**
   * Удаление пользователя навсегда из БД
   *
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function userDeleteForever(int $id)
  {
    if($user = MrUser::loadBy($id))
    {
      $user_laravel = $user->getUserLaravel();
      $user->mr_delete();

      User::find($user_laravel->id)->delete();
    }

    return Redirect::route('admin_users');
  }
}