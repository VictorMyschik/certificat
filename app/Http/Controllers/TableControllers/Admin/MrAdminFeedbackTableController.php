<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrFeedback;

class MrAdminFeedbackTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrFeedback::Select()->paginate(20, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Email', 'sort' => 'Email'),
        array('name' => 'Text', 'sort' => 'Text'),
        array('name' => 'Date', 'sort' => 'Date'),
        array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $feedback = MrFeedback::loadBy($id);

    $row[] = $feedback->id();
    $row[] = $feedback->getName();
    $row[] = $feedback->getEmail();
    $row[] = $feedback->getText();
    $row[] = $feedback->getDate()->getShortDateTitleShortTime();

    $row[] = array(
        MrLink::open('admin_feedback_edit', ['id' => $feedback->id()], '', 'btn btn-primary btn-sm fa fa-edit m-l-5',
            'Удалить'),
        MrLink::open('admin_feedback_delete', ['id' => $feedback->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
            'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}