<?php


namespace App\Http\Controllers\TableControllers\Admin;


use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\References\MrCountry;

class MrAdminDbMrCountryTableController extends MrTableController
{
  public static function buildTable(int $on_page = 10)
  {
    $body = MrCountry::Select()->paginate($on_page);

    return array(
      'header' => array(
        array('name' => 'id', 'sort' => 'id'),
        array('name' => 'Name', 'sort' => 'Name'),
        array('name' => 'ISO3166alpha2', 'sort' => 'ISO3166alpha2'),
        array('name' => 'ISO3166alpha3', 'sort' => 'ISO3166alpha3'),
        array('name' => 'ISO3166numeric', 'sort' => 'ISO3166numeric'),
        array('name' => 'Capital', 'sort' => 'Capital'),
        array('name' => 'Continent', 'sort' => 'Continent'),
      ),

      'body' => $body
    );
  }
}