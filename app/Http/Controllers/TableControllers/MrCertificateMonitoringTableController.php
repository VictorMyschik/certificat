<?php


namespace App\Http\Controllers\TableControllers;


use App\Models\Certificate\MrCertificateMonitoring;
use App\Models\MrUser;

class MrCertificateMonitoringTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrCertificateMonitoring::where('OfficeID', $args['office_id'])->orderBy('id', 'ASC')->paginate(100);
  }

  protected static function getHeader(): array
  {
    return array(
        array('name' => __('mr-t.Статус')),
        array('name' => __('mr-t.Страна')),
        array('name' => __('mr-t.Номер')),
    );
  }

  protected static function buildRow(int $id): array
  {
    $me = MrUser::me();

    $row = array();

    $certificate_monitoring = MrCertificateMonitoring::loadByOrDie($id);
    $certificate = $certificate_monitoring->getCertificate();

    $row[] = $certificate->getStatusName();
    $row[] = $certificate->getCountry()->getCodeWithName();
    $row[] = $certificate->getNumber();


    return $row;
  }
}