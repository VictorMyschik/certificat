<?php

namespace App\Http\Controllers;

use App\Http\Models\MrOffice;
use App\Http\Models\MrUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function has_permission(int $office_id)
    {
      $user = MrUser::me();
      $office = MrOffice::loadBy($office_id);
      if(!$office || !$office->canView())
      {
        mr_access_violation();
      }
      $user->setDefaultOfficeID($office->id());
      $user->save_mr();

      return $office;
    }
}
