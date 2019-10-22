<?php


namespace App\Http\Controllers\Admin\Games;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrCommand;
use App\Models\MrGame;
use App\Models\MrGamePicket;
use App\Models\MrGameResult;
use App\Models\MrParticipant;
use App\Models\MrPickets;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MrAdminGamesController extends Controller
{
  public function list()
  {
    $out = array();
    $out['list'] = MrGame::List();

    return View('Admin.game.list')->with($out);
  }

  /**
   * Создание и редактирование
   *
   * @param Request $request
   * @param int $id
   * @return Factory|View
   * @throws \Exception
   */
  public function edit(Request $request, int $id)
  {
    $game = MrGame::loadBy($id);

    if(!$game)
    {
      $game = new MrGame();
      $game->setTitle(null);
      $game->setDescription(null);
      $game->setLocation(null);
      $game->setDateStart(null);
      $game->setDateFinish(null);
      $game->setMaxCommands(null);
      $game->setMaxParticipantInCommand(null);
      $game->setPrice(null);
      $game->setDateCreate(null);
      $game->setDateCreate(null);
      $game->setPublic(false);
    }

    if($request->get('Title'))
    {
      if(!$game->id())
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Статья создана');
      }
      else
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Статья изменена');
      }

      $game->setTitle($request->get('Title', null));
      $game->setDescription($request->get('Description', null));
      $game->setLocation($request->get('Location', null));
      $game->setDateStart($request->get('DateStart', null));
      $game->setDateFinish($request->get('DateFinish', null));
      $game->setMaxCommands($request->get('MaxCommands', null));
      $game->setMaxParticipantInCommand($request->get('MaxParticipantInCommand', null));
      $game->setPrice($request->get('Price', null));
      $game->setPublic($request->get('Public', false));
      $game->setDateCreate($game->getDateCreate() ?: Carbon::now());

      $id = $game->save_mr();


      // Логотип мероприятия
      if($request->hasFile('mr_logo') && ($file = $request->file('mr_logo')))
      {
        $path = "/images/background";
        $file->move(public_path($path), 'background.jpg');
      }


      return redirect('/admin/games/edit/' . $id);
    }

    $out = array();
    $out['game'] = $game;

    return View('Admin.game.game_edit')->with($out);
  }

  public function editConditions(Request $request, int $id)
  {
    $game = MrGame::loadBy($id);

    if(!$game)
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Соревнование не найдено: id=' . $id);

      return redirect('/admin/games/list');
    }

    if($conditions = $request->get('Conditions'))
    {
      $game->setConditions((string)$conditions);

      $game->save_mr();

      return redirect('/admin/game/' . $game->id() . '/conditions/edit');
    }

    $out = array();

    $out['conditions'] = $game->getConditions();
    $out['game_title'] = $game->getTitle();

    return View('Admin.game.game_conditions_edit')->with($out);
  }

  public function delete(int $id)
  {
    if($game = MrGame::loadBy($id))
    {
      //TODO сделать удалние команд и игроков при удалении игры в целом

      $game->mr_delete();
    }

    return Redirect('/admin/games/list');
  }

  /**
   * Удаление логотпа мероприятия
   *
   * @param int $id
   * @return string
   */
  public function deleteLogo($id)
  {
    if($id !== 0)
    {
      $path = 'uploads/game_logos/' . $id . '.jpg';

      if(file_exists($path))
      {
        unlink($path);

        return 'true';
      }
      else
      {
        return 'false';
      }
    }

    return 'false';
  }

  /**
   * Состав команд
   *
   * @param int $id
   * @return Factory|View
   */
  public function userInGame(int $id)
  {
    $out = array();

    $game = MrGame::loadBy($id);
    $out['game'] = $game;

    return View('Admin.game.user_in_game')->with($out);
  }

  public function deleteCommand(int $command_id)
  {
    if($command = MrCommand::loadBy($command_id))
    {
      $game = $command->getGame();

      $command->mr_delete();

      return Redirect('/admin/game/commands/' . $game->id());
    }
    MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Команда не найдена.');
    return back();
  }

  /**
   * удаление участника из команды
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function deleteParticipant(int $id)
  {
    $participant = MrParticipant::loadBy($id);

    $participant->mr_delete();

    return back();
  }

  /**
   * Все пикеты
   */
  public function Pickets()
  {
    $out = array();
    $out['pickets'] = MrPickets::GetAll();

    return View('Admin.game.pickets')->with($out);
  }

  /**
   * Генерация пикетов
   */
  public function GeneratePickets()
  {
    for ($i = 0; $i <= 49; $i++)
    {
      $r = MrBaseHelper::RandomString();
      $code = new MrPickets();
      $code->setCode($r);

      $code->save_mr();
    }

    return back();
  }

  /**
   * Удалить все пикеты
   */
  public function DeletePickets()
  {
    MrPickets::AllDelete();

    return back();
  }

  /**
   * Страница результатов
   *
   * @param int $id
   * @return array
   */
  public function Results(int $id)
  {
    $out = array();

    $out['game'] = $game = MrGame::loadBy($id);
    return View('Admin.game.game_results')->with($out);
  }

  /**
   * Страница пикетов в игре
   *
   * @param int $id
   * @return Factory|View
   */
  public function GamePickets(int $id)
  {
    $out = array();
    $out['game'] = MrGame::loadBy($id);


    return View('Admin.game.game_pickets')->with($out);
  }

  /**
   * Удаление пикета из игры
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function gamePicketDelete(int $id)
  {
    $game_picket = MrGamePicket::loadBy($id);

    if(!$game_picket)
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Пикет в игре не найден.');
    }
    else
    {
      $game_picket->mr_delete();
    }

    return back();
  }

  /**
   * Удаление результата (только для админа)
   * @param int $id
   * @return RedirectResponse
   */
  public function resultDelete(int $id)
  {
    $result = MrGameResult::loadBy($id);
    $result->mr_delete();

    return back();
  }
}
