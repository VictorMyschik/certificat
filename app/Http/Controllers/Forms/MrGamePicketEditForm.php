<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrGame;
use App\Models\MrGamePicket;
use App\Models\MrPickets;
use Illuminate\Http\Request;

class MrGamePicketEditForm extends MrFormBase
{
  protected static function builderForm(int $game_id, int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['game_id'] = $game_id;
    $out['game_picket'] = $picket = MrGamePicket::loadBy($id) ?: new MrGamePicket();
    $out['pickets'] = MrPickets::GetAll();
    $out['title'] = $id ? "Редактирование пикета №{$picket->id()}" : 'Создать новый пикет';

    return View('Form.admin_game_pickets_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['PicketID'])
    {
      $out['PicketID'] = 'Не выбран пикет';
    }
    else
    {
      $game = MrGame::loadBy($v['game_id']);

      foreach ($game->GetGamePickets() as $picket)
      {
        if($picket->getPicket()->id() == $v['PicketID'])
        {
          $out['PicketID'] = 'Этот пикет в эту игру уже добавлен';
        }
      }
    }


    return $out;
  }

  protected static function submitForm(Request $request, int $game_id, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id] + ['game_id' => $game_id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $game_picket = MrGamePicket::loadBy($id) ?: new MrGamePicket();
    $game_picket->setGameID($v['game_id']);
    $game_picket->setPicketID($v['PicketID']);
    $game_picket->setSuccess($v['Success']);
    $game_picket->setNegative($v['Negative']);
    $game_picket->setDescription($v['Description']);

    $game_picket->save_mr();

    return;
  }
}