<?php

namespace App\Http\Controllers;

use App\Models\MrUser;
use App\Models\Office\MrOffice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Загрузка офиса, проверка доступа, переключение на офис
   *
   * @param int $office_id
   * @return MrOffice
   */
  public function has_permission(int $office_id): MrOffice
  {
    $user = MrUser::me();
    $office = MrOffice::loadBy($office_id);

    if(!$office || !$office->canView())
    {
      mr_access_violation();
    }

    $user->setDefaultOfficeID($office->id());

    $user->save_mr();
    $user->reload();

    return $office;
  }
}
