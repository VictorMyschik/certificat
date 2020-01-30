<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrUser;
use App\Http\Models\MrUsersBloked;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class MrAdminUsersController extends Controller
{
  public function index()
  {
    $out = array();
    $out['page_title'] = 'Пользователи';
    $out['users'] = MrUser::GetAll();
    $out['new_users'] = $new = MrNewUsers::GetAll();
    $out['users_blocked'] = MrUsersBloked::GetAllBlocked();
    $out['history'] = MrUsersBloked::GetAll();

    return View('Admin.mir_admin_users')->with($out);
  }

  /**
   * Установка блокировки пользователя
   *
   * @param Request $request
   * @return RedirectResponse
   * @throws Exception
   */
  public function setUserBlock(Request $request)
  {
    $user = $request->get('user');
    if(!MrUser::loadBy($user))
      return back();

    $date_to = $request->get('date_to') ?: Carbon::now()->toDateString();
    $time_to = $request->get('date_time');
    $description = $request->get('description');
    $date = new Carbon($date_to . ' ' . $time_to);

    $blocks = MrUsersBloked::GetAllBlocked();
    foreach ($blocks as $z)
    {
      if($z->getUser()->id() == $user)
      {
        $block = $z;
      }
    }
    if(!isset($block))
      $block = new MrUsersBloked();

    $block->setUserID((int)$user);
    $block->setDateFrom();
    $block->setDateTo($date);
    $block->setDescription($description);
    $block->save_mr();

    return back();
  }

  public function unblock(int $id)
  {
    $users = MrUsersBloked::loadBy($id);

    $users->setDateTo(new Carbon());
    $users->save_mr();

    return back();
  }
}