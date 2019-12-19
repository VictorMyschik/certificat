<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MtExcelHelperBase;
use Illuminate\Support\Facades\Hash;

class MrTestController extends MtExcelHelperBase
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {

  //  MrBaseHelper::sendMeByTelegram(789);
    $out = array();

    /*    $excel = self::excel();
        $sheet = $excel->getSheet(0);

        $data_map = self::SetFirstRowHeader($sheet, array(
          'Код' => 12,
          'Наименование' => 50,
          'Страна' => 7,
          'Вес' => 8,
          'Таможенная пошлина' => 35,
          'Антидемпинг' => 14,
          'Информация' => 50,
        ));

        $row_num = 1;

        $excel->setActiveSheetIndex(0);
        self::write();
    */

    //$sert = MrCertificate::Search('BY');
    //dd($sert);
dd(Hash::make(time()));
$r = '$2y$10$lBZfXf4fF.WDwep7MCpP8uIHIWCINNwuakjh5tzECWhN8IAo1ERXe';
  }
}