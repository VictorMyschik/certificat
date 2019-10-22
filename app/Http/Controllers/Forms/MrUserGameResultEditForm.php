<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrUserInGame;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MrUserGameResultEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['useringame'] = $userInGame = MrUserInGame::loadBy($id);
    $out['title'] = "Редактирование {$userInGame->getUser()->GetShortName()}";

    return View('Form.admin_user_result_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    parent::validateMaxLangthHalper($v['Description'], 'Description', 8000, $out);

    if($v['time'])
    {
      //Carbon::createFromFormat('H:i:s.u', $time);

    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
      return $errors;

    parent::submitFormBase($v);

    $user_in_game = MrUserInGame::loadBy($id);
    if($v['time'])
    {
      $time = Carbon::createFromFormat('H:i:s.u', $v['time']);
      $user_in_game->setResultTime($time);
    }
    else
    {
      $user_in_game->setResultTime(null);
    }
    $user_in_game->setDescription($v['Description']);

    $user_in_game->save_mr();
    return;
  }

}