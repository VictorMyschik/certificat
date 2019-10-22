<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrMessage;
use App\Models\MrUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MrMessageEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);
    $out['id'] = $id;
    $out['message'] = MrMessage::loadBy($id) ?: new MrMessage();
    $out['title'] = $id ? "Редактировать" : 'Создать';
    $out['users'] = MrUser::GetAll();

    return View('Form.admin_message_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Title'])
    {
      $out['Title'] = 'Заголовок сообщения обязателен';
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
      return $errors;

    parent::submitFormBase($request->all());

    if(isset($v['all_to'])) // для всех
    {
      $users = MrUser::GetAll();

      foreach ($users as $user)
      {
        $message = MrMessage::loadBy($id) ?: new MrMessage();
        $message->setTitle($v['Title']);
        $message->setText($v['text']);
        $message->setFromUserID($v['FromUserID']);
        $message->setToUserID($user->id());
        $message->setDate(new Carbon());
        $message->save_mr();
      }
    }
    else
    {
      $message = MrMessage::loadBy($id) ?: new MrMessage();
      $message->setTitle($v['Title']);
      $message->setText($v['text']);
      $message->setFromUserID($v['FromUserID']);
      $message->setDate(new Carbon());
      $message->setToUserID($v['ToUserID']);
      $message->save_mr();
    }

    return;
  }
}
