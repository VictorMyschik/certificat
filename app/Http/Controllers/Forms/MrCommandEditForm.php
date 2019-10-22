<?php


namespace App\Http\Controllers\Forms;


use App\Models\MrCommand;
use Illuminate\Http\Request;

class MrCommandEditForm extends MrFormBase
{
  protected static function builderForm(int $id)
  {
    parent::getFormBuilder($out);

    $out['id'] = $id;
    $out['command'] = $command = MrCommand::loadBy($id);
    $out['title'] = "Редактирование {$command->getName()}";

    return View('Form.admin_command_edit_form')->with($out);
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if(!$v['Name'])
    {
      return ['Name' => 'Команде необходимо наименование'];
    }

    $command = MrCommand::loadBy($v['id']);
    $command_old = $command;

    foreach ($command->getGame()->GetGameCommands() as $item)
    {
      if(($item->id() !== $command_old->id()) && ($item->getName() == $command_old->getName()))
      {
        $out['Name'] = 'Такое имя команды в этой игре уже занято';
      }
    }

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

    $command = MrCommand::loadBy($id);
    $command->setName($v['Name']);

    $command->save_mr();


    return;
  }
}