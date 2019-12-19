<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Models\MrFaq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MrAdminFaqController extends Controller
{
  public function list()
  {
    $out = array();
    $out['page_title'] = 'FAQ';
    $out['list'] = MrFaq::GetAll();

    return View('Admin.mir_admin_faq')->with($out);
  }

  public function edit(Request $request, int $id)
  {
    $out = array();
    $out['page_title'] = 'Редактирование FAQ';

    $faq = MrFaq::loadBy($id);
    if($request->getMethod() == 'POST')
    {
      if(!$faq)
      {
        $faq = new MrFaq();
      }
      $text = $request->get('Text');
      $title = $request->get('Title');

      $faq->setTitle($title);
      $faq->setText($text);
      $id = $faq->save_mr();

      return redirect('/admin/faq');
    }

    $form = array();
    $form['Title'] = array(
      '#type' => 'textfield',
      '#title' => 'Заголовок',
      '#value' => $faq ? $faq->getTitle() : null,
      '#ckeditor' => true,
    );

    $form['Text'] = array(
      '#type' => 'textarea',
      '#title' => 'Текст',
      '#value' => $faq ? $faq->getText() : null,
      '#ckeditor' => true,
    );

    $out['form'] = $form;

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
    if($faq)
    {
      $faq->mr_delete();
      MrMessageHelper::SetMessage(true, 'Успешно удалено');
    }
    else
    {
      MrMessageHelper::SetMessage(false, 'Раздел не найден');
    }


    return Redirect::route('faq');
  }
}