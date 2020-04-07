<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\MrFaq;
use App\Models\MrLanguage;
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

    if ($request->getMethod() == 'POST')
    {
      if (!$faq)
      {
        $faq = new MrFaq();
      }

      if (!$request->get('LanguageID'))
      {
        MrMessageHelper::SetMessage(1,'Выберите язык');
        return back();
      }

      $faq->setLanguageID($request->get('LanguageID'));
      $faq->setTitle($request->get('Title'));
      $faq->setText($request->get('Text'));

      $id = $faq->save_mr();

      return redirect()->route('admin_faq_page');
    }

    $form = array();

    $form['LanguageID'] = array(
      '#type'          => 'select',
      '#title'         => 'Язык',
      '#default_value' => $faq ? $faq->getLanguage()->id() : 0,
      '#value'         => [0 => 'не выбрано'] + MrLanguage::SelectList(),
      '#required'      => true,
    );

    $form['Title'] = array(
      '#type'     => 'textfield',
      '#title'    => 'Заголовок',
      '#value'    => $faq ? $faq->getTitle() : null,
      '#ckeditor' => true,
    );

    $form['Text'] = array(
      '#type'     => 'textarea',
      '#title'    => 'Текст',
      '#value'    => $faq ? $faq->getText() : null,
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
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Раздел не найден');
    }


    return back();
  }
}