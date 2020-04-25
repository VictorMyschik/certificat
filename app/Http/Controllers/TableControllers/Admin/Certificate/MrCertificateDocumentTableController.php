<?php


namespace App\Http\Controllers\TableControllers\Admin\Certificate;


use App\Helpers\MrLink;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrDocument;

class MrCertificateDocumentTableController extends MrTableController
{
  public static function GetQuery(array $args = array())
  {
    return MrDocument::Select()->paginate(50, __('mr-t.Дальше'));
  }

  protected static function getHeader(): array
  {
    return array(
      array('name' => 'id', 'sort' => 'id'),
      array('name' => 'Сертификат', 'sort' => 'CertificateID'),
      array('name' => 'Тип', 'sort' => 'Kind'),
      array('name' => 'Наименование', 'sort' => 'Name'),
      array('name' => 'Номер', 'sort' => 'Number'),
      array('name' => 'Дата', 'sort' => 'Date'),
      array('name' => 'Дата с', 'sort' => 'DateFrom'),
      array('name' => 'Дата по', 'sort' => 'DateTo'),
      array('name' => 'Организация, выдавшая документ', 'sort' => 'Organisation'),
      array('name' => 'Номер и дата документа аккредитации', 'sort' => 'Accreditation'),
      array('name' => 'Примечание', 'sort' => 'Description'),
      array('name' => 'Признак включения документа в перечень стандартов', 'sort' => 'IsInclude'),
      array('name' => '#'),
    );
  }

  protected static function buildRow(int $id): array
  {
    $row = array();

    $document = MrDocument::loadBy($id);

    $row[] = $document->id();
    $row[] = MrLink::open('admin_certificate_details', ['id' => $document->getCertificate()->id()],
      $document->getCertificate()->getNumber(), '', '', ['target' => 'blank']);
    $row[] = $document->getKind();
    $row[] = $document->getName();
    $row[] = $document->getNumber();
    $row[] = $document->getDate() ? $document->getDate()->getShortDate() : null;
    $row[] = $document->getDateFrom() ? $document->getDateFrom()->getShortDate() : null;
    $row[] = $document->getDateTo() ? $document->getDateTo()->getShortDate() : null;
    $row[] = $document->getOrganisation();
    $row[] = $document->getAccreditation();
    $row[] = $document->getDescription();
    $row[] = is_null($document->isInclude()) ? ' - ' : ((bool)$document->isInclude() ? 'да' : 'нет');

    $row[] = array(
      MrLink::open('admin_communicate_delete', ['id' => $document->id()], '', 'btn btn-danger btn-sm fa fa-trash m-l-5',
        'Удалить', ['onclick' => 'return confirm("Уверены?");']),
    );

    return $row;
  }
}