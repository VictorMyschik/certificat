<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrCountry;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MrAdminReferences extends Controller
{
  /**
   * Загрузка одного справочника
   * @param string $name
   * @return Factory|View
   */
  public function View(string $name)
  {
    $out = array();
    $out['list'] = MrCountry::GetAll();
    MrCountry::class;

    return View('Admin.mir_admin_reference_country')->with($out);
  }

  /**
   * Переустановка справочника
   * @return RedirectResponse
   */
  public function RebuildCountry()
  {
    MrCountry::RebuildReference();
    return back();
  }

  /**
   * Удаление строки из справочника по ID
   *
   * @param string $reference
   * @param int $id
   * @return RedirectResponse
   */
  public function DeleteForID(string $reference, int $id)
  {
    $pref = 'Mr';
    $l = substr($reference, 0, 1);
    $class_name = str_replace($l, mb_strtoupper($l), $reference);
    $class_name = "App\\Http\\Models\\" . $pref . $class_name;

    /** @var object $class_name */
    $row = $class_name::loadBy($id);
    $row->mr_delete();

    return back();
  }

}