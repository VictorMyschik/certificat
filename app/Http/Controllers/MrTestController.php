<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Http\Controllers\Helpers\MtExcelHelperBase;

class MrTestController extends MtExcelHelperBase
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {

    //MrBaseHelper::sendMeByTelegram(789);
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
    $headers = "Content-type: text/html; charset=UTF8 \r\n";
    $headers .= "From: " . MrBaseHelper::MR_EMAIL . "\r\n";
    $message = '1231321323213';
    $status = mail('mega-ximik@mail.ru', '456', $message, $headers);
    dd($status);
  }
}