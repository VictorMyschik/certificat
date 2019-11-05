<?php

namespace App\Http\Controllers;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MrTestController extends Controller
{
  protected $vkontakteUserId = '181953031';

  public function index()
  {
    $out = array();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');

    $writer = new Xlsx($spreadsheet);

    $file_name = 'hello world.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $file_name);
    $writer->save('hello world.xlsx');

    //return View('test')->with($out);
  }

}