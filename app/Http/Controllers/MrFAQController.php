<?php

namespace App\Http\Controllers;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Models\MrFaq;
use App\Models\MrFeedback;
use Illuminate\Http\Request;

class MrFAQController extends Controller
{
  public function index()
  {
    $out = array();

    $out['list'] = MrFaq::GetAll();

    return View('faq')->with($out);
  }

  public function Feedback(Request $request)
  {
    // Feedback
    if($request->get('text') && $request->get('name') && $request->get('email'))
    {
      $name = $request->get('name');
      $email = $request->get('email');
      $text = $request->get('text');

      // Запись в БД
      $feedback = new MrFeedback();
      $feedback->setName($name);
      $feedback->setEmail($email);
      $feedback->setText($text);
      $feedback->setReadMessage(false);
      $feedback->setDate();

      $feedback->save_mr();

      $site = MrBaseHelper::MR_DOMAIN;
      $telegramm = "$site \n $name \n $email \n $text";
      MrBaseHelper::sendMeByTelegram($telegramm);

      MrMessageHelper::SetMessage(true, 'Ваше сообщение отправлено');
    }

    return redirect('/faq');
  }
}