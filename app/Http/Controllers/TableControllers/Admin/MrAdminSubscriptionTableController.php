<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrSubscription;

class MrAdminSubscriptionTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrSubscription::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('#name' => 'id', 'sort' => 'id'),
        array('#name' => 'Email', 'sort' => 'Email'),
        array('#name' => 'Date', 'sort' => 'Date'),
        array('#name' => 'Token', 'sort' => 'Token'),
        array('#name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $subscription = MrSubscription::loadBy($id);

    $row[] = $subscription->id();
    $row[] = $subscription->getEmail();
    $row[] = $subscription->getDate()->getShortDateTitleShortTime();
    $row[] = $subscription->getToken();

    $row[] = array(
        MrLink::open('admin_subscription_delete', ['id' => $subscription->id()], '', 'btn btn-danger btn-sm fa fa-edit m-l-5',
            'Удалить подписку', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}