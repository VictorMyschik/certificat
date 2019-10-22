<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MrAdminFeedbackController extends Controller
{
    public function List()
    {
        $out = array();
        $out['list'] = MrFeedback::GetAll();

        return View('Admin.mir_admin_feedback')->with($out);
    }

    /**
     * Страница ответа на сообщения пользователей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $out = array();
        $out['message'] = MrFeedback::loadBy($id);

        return View('Admin.mir_admin_feedback_response')->with($out);
    }

    /**
     * Статус "прочитано"
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $feedback = MrFeedback::loadBy($id);
        if ($feedback) {
            $feedback->mr_delete();
            MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Успешно удалено');
        } else {
            MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Раздел не найден');
        }

        return Redirect::route('admin_feedback_list');
    }
}