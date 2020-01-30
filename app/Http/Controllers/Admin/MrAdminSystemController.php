<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Models\MrBaseLog;
use App\Http\Models\MrLogIdent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MrAdminSystemController extends Controller
{
  public function index(Request $request)
  {
    $out = array();
    $out['page_title'] = 'Лог посещения';
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

    return View('Admin.mir_admin_hardware')->with($out);
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


  public function ViewDbLog()
  {
    $out = array();
    $out['page_title'] = 'Лог БД';
    $out['list'] = MrBaseLog::GetAll();

    return View('Admin.mir_admin_bd_log')->with($out);
  }

  /**
   * @param int $id
   * @return RedirectResponse
   */
  public function deleteDbLog(int $id)
  {
    if($id == 0)
    {
      MrBaseLog::AllDelete();
    }
    else
    {
      $log = MrBaseLog::loadBy($id);

      if($log)
      {
        $log->mr_delete();
        MrMessageHelper::SetMessage(true, "Запись ID{$id} удалена");
      }
      else
      {
        MrMessageHelper::SetMessage(false, "Запись ID{$id} удалена");
      }
    }

    return back();
  }
}