<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrOffice;

class MrAdminOfficeController extends Controller
{
  public function List()
  {
    $out = array();
    $out['page_title'] = 'Виртуальные офисы';

    $out['list'] = MrOffice::GetAll();

    return View('Admin.mir_admin_office')->with($out);
  }

  public function editPage(int $id)
  {
    $out = array();
    $office = MrOffice::loadBy($id);

    if($office)
    {
      $title = 'Редактирование ВО ' . $office->getName();
    }
    else
    {
      $title = 'Создание нового ВО';
    }

    $out['page_title'] = $title;
    $out['office'] = $office;

    return View('Admin.mir_admin_office_edit')->with($out);
  }
}