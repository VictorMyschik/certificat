<?php


namespace App\Http\Controllers\Office;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrEmailHelper;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Controllers\Helpers\MrTelegramHelper;
use App\Http\Models\MrNewUsers;
use App\Http\Models\MrSubscription;
use App\Http\Models\MrUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Кабинет пользователя
 */
class MrUserController extends Controller
{
  public function PersonalPage()
  {
    $out = array();
    $out['user'] = MrUser::me();
    $out['page_title'] = __('mr-t.Личная страница');

    return View('user_page')->with($out);
  }

  public function Edit(Request $request)
  {
    $user_laravel = Auth::user();

    $messages = [
      'max' => 'Максимальня длина поля ":attribute" :max символов.',
      'min' => 'Минимальная длина поля ":attribute" :min символов.',
      'required' => 'Поле ":attribute" обязательно к заполнению.',
      'unique' => ':attribute уже занят.',
      'same' => ':attribute и :other должны совпадать.',
    ];

    Validator::make(
      $request->all(),
      [
        //'FirstName' => 'max:50',
        //'MiddleName' => 'max:50',
        //'LastName' => 'max:50',
        'Email' => [
          'required',
          'email',
          Rule::unique('users')->ignore($user_laravel->email, 'email')
        ],
        'name' => [
          'required',
          'min:3',
          Rule::unique('users')->ignore($user_laravel->name, 'name')
        ],
        'Password' => "nullable|min:6|same:password_confirm",
      ],
      $messages
    )->validate();

    $user = MrUser::me();
    //$user->setFirstName($request->get('FirstName', null));
    //$user->setMiddleName($request->get('MiddleName', null));
    //$user->setLastName($request->get('LastName', null));
    $user_laravel->email = $request->get('Email', null);
    $user_laravel->name = $request->get('name', null);

    if($pass = $request->get('Password', null))
    {
      if(strlen($pass) > 5)
      {
        $user_laravel->password = Hash::make($pass);
      }
    }

    $user_laravel->update();

    $user->save_mr();

    MrMessageHelper::SetMessage(true, 'Информация о пользователе обновлена');

    return redirect()->route('office_page');
  }

  /**
   * Отправка кода для подключения акаунта Телеграм к системе
   *
   * @param Request $request
   * @return bool
   */
  public function sendTelegramCode(Request $request): bool
  {
    $user = MrUser::me();
    if(!$user)
    {
      mr_access_violation();
    }

    if(!$code = $request->get('name'))
    {
      abort('403', 'Не найдены данные');
    }

    if(strlen($code) != MrTelegramHelper::LENGTH_CODE)
    {
      abort('403', __('mr-t.Неверный формат'));
    }

    Cache::remember('telegram_code_' . $user->id());


    return true;
  }

  /**
   * Change subscription
   *
   * @return RedirectResponse
   */
  public function ToggleSubscription()
  {
    $user = MrUser::me();

    if($user->getIsSubscription())
    {
      $subsc = MrSubscription::loadBy($user->getEmail(), 'Email');
      $subsc->mr_delete();

      MrMessageHelper::SetMessage(true, 'Подписка удалена');
    }
    else
    {
      MrSubscription::Subscription($user->getEmail());
    }

    return back();
  }

  /**
   * Удаление себя
   *
   * @return RedirectResponse|Redirector
   */
  public function DeleteSelf()
  {
    $user = MrUser::me();
    $user->AccountDelete();
    return redirect('/');
  }

  /**
   * Переотправить письмо со ссылкой для приглашённого пользователя
   * @param int $new_user_id
   */
  public function ResendForNewUser(int $new_user_id)
  {
    $new_user = MrNewUsers::loadBy($new_user_id);
    if(!$new_user || !$new_user->canEdit())
    {
      MrEmailHelper::ReSendNewUser($new_user);
    }
  }
}