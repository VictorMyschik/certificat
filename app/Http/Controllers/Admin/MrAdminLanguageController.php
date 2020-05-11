<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\MrAdminTranslateTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrLanguage;
use App\Models\MrTranslate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class MrAdminLanguageController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Страница управления языками';
    $out['route_name'] = route('admin_translate_word_table');
    $out['users'] = array();
    $out['languages'] = MrLanguage::all();

    return View('Admin.mir_admin_language')->with($out);
  }

  /**
   * Таблица переводов
   *
   * @return array
   */
  public function GetTranslateTable()
  {
    return MrTableController::buildTable(MrAdminTranslateTableController::class);
  }

  /**
   * Добавить новый язык
   *
   * @param Request $request
   * @return RedirectResponse|Redirector
   */
  public function Add(Request $request)
  {
    if ($name = $request->get('Name'))
    {
      if ($language = MrLanguage::loadBy($name))
      {
        MrMessageHelper::SetMessage(false, 'Такой язык уже добавлен');
      }
      else
      {
        $language = new MrLanguage();
        $language->setName($name);
        $language->setDescription($request->get('Description'));
        $language->save_mr();
        MrMessageHelper::SetMessage(true, "Язык {$name} успешно добавлен.");
      }
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Не указано наименование нового языка');
    }

    return redirect('/admin/language');
  }

  public function translatedWordDelete(int $id)
  {
    if ($word = MrTranslate::loadBy($id))
    {
      $word->mr_delete();
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Успешно удалено');
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, "Слово в БД не найдено id={$id}");
    }

    return redirect('/admin/language');
  }
}