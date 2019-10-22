<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\MrLogIdent;
use App\Models\MrUser;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class MrAdminController extends Controller
{
    public function index()
    {
        if (!MrUser::me()->IsAdmin()) {
            return back();
        }

        $out = array();

        $date = new Carbon();
        $date->addDays(-1);

        //$out['visits'] = MrLogIdent::GetDifferentUsers($date);

        return View('Admin.mir_admin')->with($out);
    }


    /**
     * Удаление пользователя навсегда из БД
     *
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function userDeleteForever(int $id)
    {
        if ($user = MrUser::loadBy($id))
        {
            $user_laravel = $user->getUserLaravel();
            $user->mr_delete();

            User::find($user_laravel->id)->delete();
        }

        return Redirect::route('users');
    }
}