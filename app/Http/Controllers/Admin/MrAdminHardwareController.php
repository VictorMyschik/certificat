<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\MrBotUserAgent;
use App\Models\MrLogIdent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MrAdminHardwareController extends Controller
{
  public function index(Request $request)
  {
    $out = array();
    $date = new Carbon();

    // Выбор только людей или ботов
    if($type = $request->get('type'))
    {
      self::setType($type);
    }

    if($request->get('date') == 'week')
    {
      $last_week = $date->addWeeks(-1);
      $date_name = "Показаны результаты за последнюю <b>неделю</b>";
    }
    elseif($request->get('date') == 'month')
    {
      $last_week = $date->addMonths(-1);
      $date_name = "Показаны результаты за последний <b>месяц</b>";
    }
    elseif($request->get('date') == 'year')
    {
      $last_week = $date->addYears(-1);
      $date_name = "Показаны результаты за последний <b>год</b>";
    }
    else
    {
      $last_week = $date->addDays(-1);
      $date_name = "Показаны результаты за последний <b>день</b>";
    }

    $type = $_COOKIE['type'] ?? null;
    $out['logs'] = MrLogIdent::GetAllLast($last_week, $type);
    $out['date'] = $date_name;
    // Выделение памяти
    $out['memory'] = self::getMemory();
    $out['memory_pic'] = self::getPicMemory();

    return View('Admin.mir_admin_hardware')->with($out);
  }

  public function ApiUpdate(): array
  {
    $out = array();
    $out['memory'] = self::getMemory();
    $out['memory_pic'] = self::getPicMemory();

    return $out;
  }

  public static function getMemory(): string
  {
    return (memory_get_usage(true) / 1024) . ' KB';
  }

  public static function getPicMemory(): string
  {
    return (memory_get_peak_usage(true) / 1024) . ' KB';
  }

  public static function setType(string $type)
  {
    setcookie("type", $type, time() + 3600);
  }

  /**
   * очистить лог посещений
   *
   * @return RedirectResponse
   */
  public function DeleteLogIdent()
  {
    MrLogIdent::AllDelete();

    return back();
  }

  /**
   * Добавление бота в аблицу ботов
   *
   * @param $id
   * @param $text
   * @return void
   */
  public function AddBot($id, $text)
  {
    $log = MrLogIdent::loadBy($id);

    $bot = new MrBotUserAgent();
    $bot->setUserAgent($log->getUserAgent());
    $bot->setDescription($text);
    $bot->save_mr();
  }

  /**
   * Страница ботов
   *
   * @return \Illuminate\Contracts\View\Factory|View
   */
  public function botPage()
  {
    $out = array();
    $out['bots'] = MrBotUserAgent::GetAll();
    return View('Admin.mir_admin_bot_page')->with($out);
  }

  /**
   * Удаление бота из таблицы ботов
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function DelBot(int $id)
  {
    $log = MrBotUserAgent::loadBy($id);
    $log->mr_delete();

    return back();
  }

}