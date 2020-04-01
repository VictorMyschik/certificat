<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\MrSubscription;
use Illuminate\Http\Request;

class MrAdminSubscription extends Controller
{
  public function index()
  {
    $out = array();
    $out['page_title'] = 'Подписка пользователей на обновления';
    $out['emails'] = MrSubscription::GetAll();

    return View('Admin.mir_admin_subscription')->with($out);
  }

  public function UnSubscription(int $id)
  {
    $sub = MrSubscription::loadBy($id);
    if($sub)
    {
      $sub->mr_delete();
    }

    MrMessageHelper::SetMessage(true,
      'Email: ' . $sub->getEmail() . ' успешно отписн от рассылки');

    return back();
  }

  public function NewSubscription(Request $request)
  {
    $email = $request->get('email');
    $regex = '/\S+@\S+\.\S+/';
    if(preg_match($regex, $email))
    {
      MrSubscription::Subscription($email);
    }

    return back();
  }
}