<?php


namespace App\Http\Controllers\TableControllers\Admin\System;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\MrOffice;

class MrAdminDbMrOfficesTableController extends MrTableController
{
  public static function SystemBuildTable(int $on_page = 10)
  {
    $body = MrOffice::Select(['*'])->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'Description', 'sort' => 'Description'),
        array('name' => 'UNP', 'sort' => 'UNP'),
        array('name' => 'CountryID', 'sort' => 'CountryID'),
        array('name' => 'Email', 'sort' => 'Email'),
        array('name' => 'Phone', 'sort' => 'Phone'),
        array('name' => 'POPostalCode', 'sort' => 'POPostalCode'),
        array('name' => 'PORegion', 'sort' => 'PORegion'),
        array('name' => 'POCity', 'sort' => 'POCity'),
        array('name' => 'POAddress', 'sort' => 'POAddress'),
        array('name' => 'URPostalCode', 'sort' => 'URPostalCode'),
        array('name' => 'URRegion', 'sort' => 'URRegion'),
        array('name' => 'URCity', 'sort' => 'URCity'),
        array('name' => 'URAddress', 'sort' => 'URAddress'),
        array('name' => 'BankRS', 'sort' => 'BankRS'),
        array('name' => 'BankName', 'sort' => 'BankName'),
        array('name' => 'BankCode', 'sort' => 'BankCode'),
        array('name' => 'BankAddress', 'sort' => 'BankAddress'),
        array('name' => 'PersonSign', 'sort' => 'PersonSign'),
        array('name' => 'PersonPost', 'sort' => 'PersonPost'),
        array('name' => 'PersonFIO', 'sort' => 'PersonFIO'),
      ),

      'body' => $body
    );
  }
}