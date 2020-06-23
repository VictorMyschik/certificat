<?php

namespace App\Http\Controllers\TableControllers;

use App\Models\Certificate\MrCertificateMonitoring;

class MrCertificateMonitoringTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrCertificateMonitoring::Select(['mr_certificate_monitoring.id'])->where('mr_certificate_monitoring.OfficeID', $args['office_id'])
        ->join('mr_certificate', 'mr_certificate.id', '=', 'mr_certificate_monitoring.CertificateID')->limit(50)
        ->paginate(100);
  }

  protected static function getHeader(): array
  {
    return array(
        array('#checkbox' => 'all'),
        array('#name' => __('mr-t.Статус'), 'sort' => 'mr_certificate.Status'),
        array('#name' => __('mr-t.Страна'), 'sort' => 'mr_certificate.CountryID'),
        array('#name' => __('mr-t.Дата документа'), 'sort' => 'mr_certificate.DateFrom'),
        array('#name' => __('mr-t.Срок действия'), 'sort' => 'mr_certificate.DateTo'),
        array('#name' => __('mr-t.Номер'), 'sort' => 'mr_certificate.Number'),
        array('#name' => __('mr-t.Заявитель'), 'sort' => 'mr_certificate.ApplicantID'),
    );
  }

  protected static function buildRow(int $id, array $args): array
  {
    $row = array();

    $certificate_monitoring = MrCertificateMonitoring::loadByOrDie($id);
    $certificate = $certificate_monitoring->getCertificate();

    $row[] = $certificate_monitoring->id();
    $row[] = $certificate->getCountry()->GetCodeWithTitleName();
    $row[] = $certificate->GetDisplayStatusHtml();
    $row[] = $certificate->getDateFrom() ? $certificate->getDateFrom()->getShortDate() : null;
    $row[] = $certificate->getDateTo() ? $certificate->getDateTo()->getShortDate() : null;
    $row[] = $certificate->getNumber();
    $row[] = $certificate->getApplicant()->getName();

    return $row;
  }
}