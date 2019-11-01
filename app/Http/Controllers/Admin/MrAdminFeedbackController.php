<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrFeedback;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MrAdminFeedbackController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Feedback';
    $out['list'] = MrFeedback::GetAll();

    return View('Admin.mir_admin_feedback')->with($out);
  }

  /**
   * Страница ответа на сообщения пользователей
   *
   * @return Factory|View
   */
  public function edit(int $id)
  {
    $out = array();
    $out['page_title'] = 'Feedback ответ';
    $out['message'] = MrFeedback::loadBy($id);

    return View('Admin.mir_admin_feedback_response')->with($out);
  }

  /**
   * Статус "прочитано"
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function read(int $id)
  {
    $message = MrFeedback::loadBy($id);
    //$message->setReadMessage(true);
    $message->save_mr();

    return Redirect::route('admin_feedback_edit', [$id]);
  }

  /**
   * Отправить сообщение
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function send(Request $request, int $id)
  {
    $message = MrFeedback::loadBy($id);
    $text = $request->get('text');
    $message->setSendMessage($text);
    $message->save_mr();

    return Redirect::route('admin_feedback_edit', [$id]);
  }

  /**
   * Удаление по id
   *
   * @param $id
   * @return RedirectResponse
   */
  public function delete($id)
  {
    $feedback = MrFeedback::loadBy($id);
    if($feedback)
    {
      $feedback->mr_delete();
      MrMessageHelper::SetMessage(true, 'Успешно удалено');
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Раздел не найден');
    }

    return Redirect::route('admin_feedback_list');
  }
}