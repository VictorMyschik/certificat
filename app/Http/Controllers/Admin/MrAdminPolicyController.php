<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Models\MrLanguage;
use App\Models\MrPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MrAdminPolicyController extends Controller
{
  public function List()
  {
    $out = array();
    $out['list'] = MrPolicy::GetAll();

    return View('Admin.mir_admin_policy')->with($out);
  }

  public function edit(Request $request, int $id)
  {
    $policy = MrPolicy::loadBy($id);
    if(!$policy)
    {
      $policy = new MrPolicy();
      $policy->setLanguageID(null);
      $policy->setText('');
    }

    if($request->get('LanguageID'))
    {
      $policy->setLanguageID($request->get('LanguageID'));
      $policy->setText($request->get('Text'));
      $id = $policy->save_mr();

      return redirect('/admin/policy');
    }
/*
    $messages = [
      'required' => 'Поле ":attribute" обязательно к заполнению.',
      'unique' => ':attribute уже занят.',
      'same' => ':attribute и :other должны совпадать.',
    ];

    Validator::make(
      $request->all(),
      [
        'Email' => [
          'required',
          'email',
        ],
        'name' => [
          'required',
          'min:3',
        ],
        'Password' => "nullable|min:6|same:password_confirm",
      ],

      $messages

    )->validate();

*/

    $out = array();
    $out['policy'] = $policy;
    $out['languages'] = MrLanguage::GetAll();
    return View('Admin.mir_admin_policy_edit')->with($out);
  }

  /**
   * Удаление по id
   *
   * @param $id
   * @return RedirectResponse
   */
  public function delete($id)
  {
    $faq = MrPolicy::loadBy($id);
    if($faq)
    {
      $faq->mr_delete();
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, 'Успешно удалено');
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Запись не найдена');
    }


    return Redirect::route('admin_policy_list');
  }
}