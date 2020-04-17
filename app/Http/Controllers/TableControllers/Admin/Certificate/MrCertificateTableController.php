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
      array('name' => 'Тип', 'sort' => 'CertificateKindID'),
      array('name' => 'Номер', 'sort' => 'Number'),
      array('name' => 'Дата с', 'sort' => 'DateFrom'),
      array('name' => 'Дата по', 'sort' => 'DateTo'),
      array('name' => 'Страна', 'sort' => 'CountryID'),
      array('name' => 'Статус', 'sort' => 'Status'),
      array('name' => 'Эксперт-аудитор', 'sort' => 'AuditorID'),
      array('name' => 'Номер бланка', 'sort' => 'BlankNumber'),
      array('name' => 'Статус С', 'sort' => 'DateStatusFrom'),
      array('name' => 'Статус до', 'sort' => 'DateStatusTo'),
      array('name' => 'Документ основание', 'sort' => 'DocumentBase'),
      array('name' => 'Причина изменения', 'sort' => 'WhyChange'),
      array('name' => 'Схема серитфикации', 'sort' => 'SchemaCertificate'),
      array('name' => 'Доп.инфа', 'sort' => 'Description'),
      array('name' => 'Ссылка XML ЕАЭС', 'sort' => 'LinkOut'),
      array('name' => 'Дата записи в ЕАЭС', 'sort' => 'DateUpdateEAES'),
      array('name' => 'Признак включения продукции в единый перечень', 'sort' => 'SingleListProductIndicator'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $certificate = MrCertificate::loadBy($id);

    $row[] = $certificate->id();
    $row[] = $certificate->getCertificateKind()->getShortName();
    $url = 'https://portal.eaeunion.org/sites/commonprocesses/ru-ru/Pages/CardView.aspx?documentId=' . $certificate->getHash() . '&codeId=P.TS.01';
    $row[] = '<a href="' . $url . '" target="_blank">' . $certificate->getNumber() . '</a>';
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
    $link_out = $certificate->getLinkOut();
    $row[] = '<a href="' . htmlspecialchars($link_out) . '" target="_blank" class="text-nowrap"><i class="fa fa-link"> XML</a>';
    $row[] = $certificate->getDateUpdateEAES()->getShortDateTitleShortTime();
    $row[] = $certificate->getSingleListProductIndicator();

    $row[] = array(
      MrLink::open('admin_certificate_delete', ['id' => $certificate->id()], '', 'btn btn-danger btn-sm fa fa-trash',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
      MrLink::open('admin_certificate_update', ['id' => $certificate->id()], 'Update', 'btn btn-success btn-sm fa fa-refresh',
        'Обновить'),
    );

    return $row;
  }
}