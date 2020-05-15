<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\MrAdminEmailTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrEmailLog;

class MrAdminEmailController extends Controller
{
  public function List()
  {
    $out = array();
    $out['list'] = MrEmailLog::all();
    $out['page_title'] = 'Отправленная почта';
    $out['route_name'] = route('admin_email_table');

    return View('Admin.mir_admin_email_list')->with($out);
  }

  public function GetEmailTable()
  {
    return MrTableController::buildTable(MrAdminEmailTableController::class);
  }

  public function EmailDelete(int $id)
  {
    if($id == -1)
    {
      MrEmailLog::AllDelete();
    }
    else
    {
      $email = MrEmailLog::loadBy($id);
      $email->mr_delete();
    }

    return back();
  }
}