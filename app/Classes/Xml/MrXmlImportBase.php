<?php


namespace App\Classes\Xml;


use App\Http\Controllers\Controller;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use SimpleXMLElement;

/**
 * Базовый класс для импорта данных из XML
 */
class MrXmlImportBase extends Controller
{
  /**
   * @param $str
   * @return MrCertificate[]
   */
  public static function ParseXmlFromString($str): array
  {
    $xml = simplexml_load_string($str);

    return self::parse($xml);
  }

  /**
   * @param $xml
   * @return array
   */
  public static function parse($xml): array
  {
    $certificate_out = array();

    // В файл могут запаковать несколько сертификатов, тогда каждый завёрнут в "entry"
    if(isset($xml->entry))
    {
      foreach ($xml->entry as $key => $item)
      {
        $ns = $item->content->children('http://schemas.microsoft.com/ado/2007/08/dataservices/metadata');
        $nsd = $ns->properties->children("http://schemas.microsoft.com/ado/2007/08/dataservices");
        $link_out = (string)$item->id;

        $certificate_out[] = self::importCertificate($nsd, $link_out);
      }
    }
    else
    { // в одном файле один сертификат
      $ns = $xml->content->children('http://schemas.microsoft.com/ado/2007/08/dataservices/metadata');
      $nsd = $ns->properties->children("http://schemas.microsoft.com/ado/2007/08/dataservices");
      $link_out = (string)$xml->id;

      $certificate_out[] = self::importCertificate($nsd, $link_out);
    }

    return $certificate_out;
  }

  /**
   * Импорт сертификата
   *
   * @param SimpleXMLElement $xml
   * @param string $link_out
   * @return MrCertificate|null
   */
  public static function importCertificate(SimpleXMLElement $xml, string $link_out): ?MrCertificate
  {
    // Сведения о сертификате
    $certificate = self::importCertificateDetails($xml, $link_out);
    // Сведения об органе по оценке соответствия
    $conformity_authority = self::importConformityAuthority($xml->conformityAuthorityV2Details);

    return $certificate;
  }

  /**
   * Импорт ФИО
   *
   * @param SimpleXMLElement $xml
   * @return MrFio|null
   */
  public static function importFio(SimpleXMLElement $xml): ?MrFio
  {
    $fio = null;

    if(isset($xml->element))
    {
      $xml = $xml->element;

      $fio = new MrFio();

      $fio->setPositionName((string)$xml->positionName ?: null);

      if(isset($xml->element))
      {
        $full_name = $xml->element;
      }
      else
      {
        $full_name = $xml;
      }

      $fio->setFirstName($full_name->firstName);
      $fio->setMiddleName($full_name->middleName);
      $fio->setLastName($full_name->lastName);

      $fio->save_mr();
    }
    elseif(isset($xml->fullNameDetails))
    {
      $full_name = $xml->fullNameDetails;

      $fio->setFirstName((string)$full_name->firstName);
      $fio->setMiddleName((string)$full_name->middleName);
      $fio->setLastName((string)$full_name->lastName);
    }
    dd($xml);
    return $fio;
  }

  /**
   * Импорт органа по оценке соответствия
   *
   * @param SimpleXMLElement $xml
   * @return MrConformityAuthority
   */
  public static function importConformityAuthority(SimpleXMLElement $xml)
  {
    //  dd($xml);

    if(isset($xml->officerDetails))
    {
      $officer = self::importFio($xml->officerDetails);
    }

    // Номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    $authority_id = (string)$xml->conformityAuthorityId;
    $conformity = MrConformityAuthority::loadBy($authority_id, 'ConformityAuthorityId') ?: new MrConformityAuthority();

    // Страна
    $country_xml = (string)$xml->unifiedCountryCode->value;
    if($country = MrCountry::loadBy($country_xml, 'ISO3166alpha2'))
    {
      $conformity->setCountryID($country->id());
    }

    $conformity->setConformityAuthorityId($authority_id);
    $conformity->setDocumentNumber((string)$xml->docId);
    $conformity->setDocumentDate((string)$xml->docCreationDate);
    $conformity->setName((string)$xml->businessEntityName);

    // руководитель
    if($officer ?? null)
    {
      $conformity->setOfficerDetailsID($officer->id());
    }

    dd($conformity);
    // $conformity->save_mr();

    return $conformity;
  }

  /**
   * Парсинг самого сертификата
   *
   * @param SimpleXMLElement $xml
   * @param string $link_out
   * @return MrCertificate|null
   */
  protected static function importCertificateDetails(SimpleXMLElement $xml, string $link_out): ?MrCertificate
  {
    $number = (string)$xml->docId;

    if(isset(MrCertificate::GetHashedList()[$number]))
    {
      $certificate = MrCertificate::loadBy($number, 'Number');
    }
    else
    {
      $certificate = new MrCertificate();
      MrCertificate::GetHashedList()[$number] = $number;
    }

    $certificate->setLinkOut($link_out);

    // Страна
    $country_code_xml = (string)$xml->unifiedCountryCode->value;
    $country = MrCountry::loadBy($country_code_xml, 'ISO3166alpha2');

    if(!$country)
    {
      dd($country_code_xml . ' страна не найдена в справочнике в столбце ISO3166alpha2');
    }

    $certificate->setCountryID($country->id());

    // Номер
    $certificate->setNumber($number);

    // Дата начала действия сертификата
    $date_from = (string)$xml->docStartDate;
    $certificate->setDateFrom($date_from);

    // Дата окончания действия
    $date_to = $xml->docValidityDate;
    $certificate->setDateTo($date_to);

    // Номер бланка
    $formNumberId = (string)$xml->formNumberId;
    $certificate->setBlankNumber(strlen($formNumberId) ? $formNumberId : null);

    /**
     * Признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с
     * выдачей сертификатов соответствия и деклараций о соответствии по единой форме:
     * 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
     * */
    $singleListProductIndicator = (bool)$xml->singleListProductIndicator;
    $certificate->setSingleListProductIndicator($singleListProductIndicator);

    // Тип документа
    $conformityDocKindCode = (string)$xml->conformityDocKindCode;
    $cert_kind = MrCertificateKind::loadBy($conformityDocKindCode, 'Code');
    $certificate->setCertificateKindID($cert_kind->id());

    //// Статус
    $docStatusDetails = $xml->docStatusDetails;
    $status_code = (int)$docStatusDetails->docStatusCode;
    $certificate->setStatus($status_code);

    // Начальная дата действия статуса
    $status_date_from = (string)$docStatusDetails->startDate;
    //dd($status_date_from);
    $certificate->setDateStatusFrom($status_date_from);
    // Конечная дата действия статуса
    $status_date_to = (string)$docStatusDetails->EndDate;
    $certificate->setDateStatusTo($status_date_to ?: $date_to);

    // Схема сертификации
    $schema_certificate = (string)$xml->certificationSchemeCode->element;
    $certificate->setSchemaCertificate($schema_certificate);

    $DateUpdateEAES = (string)$xml->resourceItemStatusDetails->updateDateTime;
    $certificate->setDateUpdateEAES($DateUpdateEAES);

    /*  if($fio_xml = $xml->fullNameDetails)
      {
        if($fio = self::importFio($fio_xml))
        {
          $certificate->setAuditorID($fio->id());
        }
      }
  */
    $certificate->save_mr();
    $certificate->reload();

    return $certificate;
  }
}