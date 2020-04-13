<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\MrAdminSystemDbLogTableController;
use App\Http\Controllers\TableControllers\Admin\MrAdminSystemLogIdentTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrBaseLog;
use App\Models\MrLogIdent;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MrAdminSystemController extends Controller
{
  public function index(Request $request)
  {
    $out = array();
    $out['page_title'] = 'Лог посещения';
    $out['route_name'] = route('admin_system_table');

    return View('Admin.mir_admin_hardware')->with($out);
  }

  /**
   * API получение данных для таблицы посещеня сайта
   */
  public function GetLogIdentTable()
  {
    return MrTableController::buildTable(MrAdminSystemLogIdentTableController::class);
  }

  /**
   * API получение данных для таблицы посещеня сайта
   */
  public function GetDbLogTable()
  {
    return MrTableController::buildTable(MrAdminSystemDbLogTableController::class);
  }

  /**
   * Страница лога записей в БД
   *
   * @return Factory|View
   */
  public function ViewDbLog()
  {
    $out = array();
    $out['page_title'] = 'Лог базы данных';
    $out['route_name'] = route('admin_db_log_table');

    return View('Admin.mir_admin_bd_log')->with($out);
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
   * Очистить лог посещений
   *
   * @return RedirectResponse
   */
  public function DeleteLogIdent()
  {
    MrLogIdent::AllDelete();

    return back();
  }

  /**
   * @return RedirectResponse
   */
  public function deleteDbLog()
  {
    MrBaseLog::AllDelete();

    return back();
  }

  public function deleteDbLogRow(int $id)
  {
    $log = MrBaseLog::loadBy($id);
    $log->mr_delete();

    return back();
  }
}