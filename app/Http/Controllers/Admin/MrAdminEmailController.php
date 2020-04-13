<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\MrEmailLog;

class MrAdminEmailController extends Controller
{
  public function List()
  {
    $out = array();
    $out['list'] = MrEmailLog::GetAll();

    return View('Admin.mir_admin_email_list')->with($out);
  }

  public function EmailDelete(int $id)
  {
    if ($id == -1)
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