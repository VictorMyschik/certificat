<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrCommand;
use App\Models\MrGame;
use App\Models\MrParticipant;
use Illuminate\Http\Request;

class MrParticipantEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['participant'] = $participant = MrParticipant::loadBy($id);
    $out['last_game'] = $game = MrGame::GetFutureGame();
    $out['commands'] = $game->GetGameCommands();
    $out['title'] = "Редактирование {$participant->getFio()}";

    return View('Form.admin_participant_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);


    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($v + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($v);

    $participant = MrParticipant::loadBy($id);
    $old_command = $participant->getCommand();

    //// Команда
    if(isset($v['NewCommandName']) && $v['select_command'] == 0)
    {
      $command = new MrCommand();
      $command->setName($v['NewCommandName']);
      $command->setAuthorUserID($participant->getUser()->id());
      $command->setGameID($participant->getCommand()->getGame()->id());

      $command_id = $command->save_mr();

      // Проверка старой команды
      if($old_command->getAuthorUser()->id() == $participant->getUser()->id())
      {
        $old_users = $old_command->GetUsers();
        if($old_users > 1)
        {
          foreach ($old_users as $users)
          {
            if($users->id() !== $old_command->getAuthorUser()->id())
            {
              $old_command->setAuthorUserID($users->id());
              $old_command->save_mr();
            }
          }
        }

      }
    }
    else
    {
      $command_id = $v['select_command'];
    }

    //// Регистрация участника
    $participant->setCommandID($command_id);
    $participant->setFirstName($v['FirstName']);
    $participant->setLastName($v['LastName']);
    $participant->setPhone($v['Phone']);
    $participant->setBirth($v['Birth']);
    $participant->setCity($v['City']);
    $participant->setGender($v['Gender']);
    $participant->setPassport($v['Passport']);

    $participant->save_mr();


    // если после редактирование не осталось участников, удаляем команду
    if(!count($old_command->GetUsers()))
    {
      $old_command->mr_delete();
    }

    return;
  }

}