<?php

namespace App\Http\Controllers;


use App\Models\MrSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MrSubscriptionController extends Controller
{
  /** Страница подписки
   *
   * @param Request $request
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   * @throws \Exception
   */
  public function Subscription(Request $request)
  {
    $message = '';
    $out = array();
    if($email = (string)$request->get('email'))
    {
      $regex = '/\S+@\S+\.\S+/';
      if(preg_match($regex, $email))
      {
        $message = 'Подписка на обновления принята. Спасибо, что доверяете нам.';

        // Подписка
        if(!$exist = MrSubscription::loadBy($email, 'Email'))
        {
          MrSubscription::Subscription($email);
        }
      }
      else
      {
        $message = 'Пожалуйста, введите правильный Email-адрес.';
      }
    }

    $out['message'] = $message;

    if($request->get('return'))
    {
      return back();
    }

    return View('subscription.subscription')->with($out);
  }

  /**
   * Отписка
   *
   * @param Request     $request
   * @param null|string $token
   * @return \Illuminate\Http\RedirectResponse
   */
  public function UnSubscription(Request $request, ?string $token)
  {
    $out = array();
    if(!$token || (!$sub = MrSubscription::loadBy($token, 'Token')))
    {
      return Redirect::action('MrSubscriptionController@Subscription');
    }
    else
    {
      $sub->mr_delete();
    }

    $out['message'] = 'Вы отписаны от всех рассылок. Спасибо, что были с нами всё это время.';

    if($request->get('return'))
    {
      return back();
    }


    return View('subscription.un_subscription')->with($out);
  }

}