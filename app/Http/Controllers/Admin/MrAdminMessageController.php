<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrMessage;
use Illuminate\Http\RedirectResponse;

class MrAdminMessageController extends Controller
{
  public function List()
  {
    $out = array();

    $out['list'] = MrMessage::GetAll();

    return View('Admin.mir_admin_message')->with($out);
  }

  /**
   * Удаление соощения
   * @param int $id
   * @return RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function deleteMessage(int $id)
  {
    $message = MrMessage::loadBy($id);
    $message->mr_delete();

    return Redirect('/admin/messages');
  }
}