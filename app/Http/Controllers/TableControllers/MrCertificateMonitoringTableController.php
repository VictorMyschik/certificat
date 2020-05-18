<?php

namespace App\Http\Controllers\TableControllers;

use App\Helpers\MrLink;
use App\Models\Certificate\MrCertificateMonitoring;
use App\Models\Office\MrOffice;

class MrCertificateMonitoringTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrCertificateMonitoring::Select(['mr_certificate_monitoring.id'])->where('mr_certificate_monitoring.OfficeID', $args['office_id'])
      ->join('mr_certificate', 'mr_certificate.id', '=', 'mr_certificate_monitoring.CertificateID')
      ->paginate(100);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => __('mr-t.Статус'), 'sort' => 'mr_certificate.Status'),
      array('name' => __('mr-t.Страна'), 'sort' => 'mr_certificate.Country'),
      array('name' => __('mr-t.Номер'), 'sort' => 'mr_certificate.Number'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id, array $args): array
  {
    $office = MrOffice::loadBy($args['office_id']);
    $row = array();

    $certificate_monitoring = MrCertificateMonitoring::loadByOrDie($id);
    $certificate = $certificate_monitoring->getCertificate();

    $row[] = $certificate->getStatusName();
    $row[] = __('mr-t.' . $certificate->getCountry()->getName());
    $row[] = $certificate->getNumber();

    if($office->canEdit())
    {
      //$delete = MrLink::open('');
    }

    $row[] = $certificate_monitoring->id();

    return $row;
  }
}