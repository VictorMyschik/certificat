<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrFaq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MrAdminFaqController extends Controller
{
  public function list()
  {
    $out = array();

    $out['list'] = MrFaq::GetAll();
    return View('Admin.mir_admin_faq')->with($out);
  }

  public function edit(Request $request, int $id)
  {
    $faq = MrFaq::loadBy($id);
    if (!$faq)
    {
      $faq = new MrFaq();
      $faq->setTitle('');
      $faq->setText('');
    }

    if ($request->get('title'))
    {
      $text = $request->get('text');
      $title = $request->get('title');

      $faq->setTitle($title);
      $faq->setText($text);
      $id = $faq->save_mr();

      return redirect('/admin/faq');
    }

    $out = array();
    $out['faq'] = $faq;
    $out['list'] = MrFaq::GetAll();

    return View('Admin.mir_admin_faq_edit')->with($out);
  }

  /**
   * Удаление по id
   *
   * @param $id
   * @return RedirectResponse
   */
  public function delete($id)
  {
    $faq = MrFaq::loadBy($id);
    if ($faq)
    {
        $faq->mr_delete();
        MrMessageHelper::SetMessage(true,'Успешно удалено');
    }
    else
    {
        MrMessageHelper::SetMessage(false,'Раздел не найден');
    }


    return Redirect::route('faq');
  }
}