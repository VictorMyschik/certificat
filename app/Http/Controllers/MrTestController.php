<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MtExcelHelperBase;
use App\Http\Models\MrCertificate;

class MrTestController extends MtExcelHelperBase
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
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

    $sert = MrCertificate::Search('BY');
    dd($sert);

  }
}