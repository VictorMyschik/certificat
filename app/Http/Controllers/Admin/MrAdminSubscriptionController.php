<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\MrAdminSubscriptionTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MrAdminSubscriptionController extends Controller
{
  public function index()
  {
    $out = array();
    $out['page_title'] = 'Подписка пользователей на обновления';
    $out['route_name'] = route('admin_subscription_table');

    return View('Admin.mir_admin_subscription')->with($out);
  }

  /**
   * Subscription table
   *
   * @return array
   */
  public function GetSubscriptionTable(): array
  {
    return MrTableController::buildTable(MrAdminSubscriptionTableController::class);
  }

  /**
   * Отписать пользователя
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function UnSubscription(int $id)
  {
    $sub = MrSubscription::loadBy($id);
    if ($sub)
    {
      $sub->mr_delete();

      MrMessageHelper::SetMessage(true, 'Email: ' . $sub->getEmail() . ' успешно отписн от рассылки');
    }

    return back();
  }

  /**
   * Запрос на новую подписку
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function NewSubscription(Request $request)
  {
    $email = $request->get('email');
    if (preg_match('/\S+@\S+\.\S+/', $email))
    {
      MrSubscription::Subscription($email);
    }

    return back();
  }
}