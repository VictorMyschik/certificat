<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrLanguage;
use App\Models\MrTranslate;
use Illuminate\Http\Request;

class MrAdminLanguageController extends Controller
{
  public function List()
  {
    $out = array();

    $out['users'] = array();
    $out['languages'] = MrLanguage::GetAll();
    $out['translate'] = MrTranslate::GetAll();

    return View('Admin.mir_admin_language')->with($out);
  }

  /**
   * Добавить новый язык
   *
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function Add(Request $request)
  {
    if($name = $request->get('Name'))
    {
      if($language = MrLanguage::loadBy($name))
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Такой язык уже добавлен');
      }
      else
      {
        $language = new MrLanguage();
        $language->setName($name);
        $language->setDescription($request->get('Description'));
        $language->save_mr();
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, "Язык {$name} успешно добавлен.");
      }
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Не указано наименование нового языка');
    }

    return redirect('/admin/language');
  }

  public function translatedWordDelete(int $id)
  {
    if($word = MrTranslate::loadBy($id))
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