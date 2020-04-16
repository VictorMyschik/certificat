<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrCertificate;

class MrCertificateTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrCertificate::Select()->paginate(20);
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'CertificateKindID', 'sort' => 'CertificateKindID'),
      array('name' => 'Number', 'sort' => 'Number'),
      array('name' => 'DateFrom', 'sort' => 'DateFrom'),
      array('name' => 'DateTo', 'sort' => 'DateTo'),
      array('name' => 'CountryID', 'sort' => 'CountryID'),
      array('name' => 'Status', 'sort' => 'Status'),
      array('name' => 'AuditorID', 'sort' => 'AuditorID'),
      array('name' => 'BlankNumber', 'sort' => 'BlankNumber'),
      array('name' => 'DateStatusFrom', 'sort' => 'DateStatusFrom'),
      array('name' => 'DateStatusTo', 'sort' => 'DateStatusTo'),
      array('name' => 'DocumentBase', 'sort' => 'DocumentBase'),
      array('name' => 'WhyChange', 'sort' => 'WhyChange'),
      array('name' => 'SchemaCertificate', 'sort' => 'SchemaCertificate'),
      array('name' => 'Description', 'sort' => 'Description'),
      array('name' => 'LinkOut', 'sort' => 'LinkOut'),
      array('name' => 'DateUpdateEAES', 'sort' => 'DateUpdateEAES'),
      array('name' => 'SingleListProductIndicator', 'sort' => 'SingleListProductIndicator'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $certificate = MrCertificate::loadBy($id);

    $row[] = $certificate->id();
    $row[] = $certificate->getCertificateKind()->getShortName();
    $row[] = $certificate->getNumber();
    $row[] = $certificate->getDateFrom() ? $certificate->getDateFrom()->getShortDateTitleShortTime() : '';
    $row[] = $certificate->getDateTo() ? $certificate->getDateTo()->getShortDateTitleShortTime() : '';
    $row[] = $certificate->getCountry()->getName();
    $row[] = $certificate->getStatus();
    $row[] = $certificate->getAuditor() ? $certificate->getAuditor()->GetFullName() : '';
    $row[] = $certificate->getBlankNumber();
    $row[] = $certificate->getDateStatusFrom() ? $certificate->getDateStatusFrom()->getShortDateTitleShortTime() : '';
    $row[] = $certificate->getDateStatusTo() ? $certificate->getDateStatusTo()->getShortDateTitleShortTime() : '';
    $row[] = $certificate->getDocumentBase();
    $row[] = $certificate->getWhyChange();
    $row[] = $certificate->getSchemaCertificate();
    $row[] = $certificate->getDescription();
    $row[] = $certificate->getLinkOut();
    $row[] = $certificate->getDateUpdateEAES()->getShortDateTitleShortTime();
    $row[] = $certificate->getSingleListProductIndicator();

    $row[] = array(
      MrLink::open('admin_certificate_delete', ['id' => $certificate->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
      MrLink::open('admin_certificate_update', ['id' => $certificate->id()], 'update', 'btn btn-success btn-sm fa fa-refresh m-l-5',
        'Обновить'),
    );

    return $row;
  }
}