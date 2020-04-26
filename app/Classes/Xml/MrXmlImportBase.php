<?php

namespace App\Classes\Xml;

use App\Http\Controllers\Controller;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrDocument;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use App\Models\Lego\MrCertificateDocument;
use App\Models\Lego\MrCommunicateInTable;
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
   * Парсинг загруженного XML файла
   *
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

    //// Сведения об органе по оценке соответствия
    if(isset($xml->conformityAuthorityV2Details))
    {
      $conformity_authority = self::importConformityAuthority($xml->conformityAuthorityV2Details);
    }

    if(isset($conformity_authority))
    {
      $certificate->setAuthorityID($conformity_authority->id());
    }

    //// Производитель
    if(isset($xml->technicalRegulationObjectDetails))
    {
      $technical_xml = $xml->technicalRegulationObjectDetails;
      if(isset($technical_xml->manufacturerDetails))
      {
        $manufacturer = self::importManufacturer($technical_xml->manufacturerDetails);

        if($manufacturer)
        {
          $certificate->setManufacturerID($manufacturer->id());
        }
      }
    }

    $certificate_id = $certificate->save_mr();
    $certificate->reload();

    // Документы
    if(isset($xml->complianceDocDetails) || isset($xml->DocInformationDetails))
    {
      self::importDocument($xml, $certificate);
    }

    return $certificate;
  }

  /**
   * Импорт документов, привязанных к сертификату
   *
   * @param SimpleXMLElement $xml_doc
   * @param MrCertificate $certificate
   */
  protected static function importDocument(SimpleXMLElement $xml_doc, MrCertificate $certificate): void
  {
    // Документы, подтверждающие соответствие требованиям
    if(isset($xml_doc->complianceDocDetails))
    {
      $xml_doc_equals = $xml_doc->complianceDocDetails;

      if(isset($xml_doc_equals->element))
      {
        foreach ($xml_doc_equals->element as $xml)
        {
          if(isset($xml->docId) && ($number_xml = (string)$xml->docId))
          {
            $number_xml = (string)$xml->docId;
          }

          if(isset($xml->docName) && ($name_xml = (string)$xml->docName))
          {
            $name_xml = (string)$xml->docName;
          }

          $document = MrDocument::loadBy($name_xml, 'Number');

          if(!$document)
          {
            $document = MrDocument::loadBy($name_xml, 'Name');
          }


          /// Поиск дубликатов
          $has = false;
          if($document)
          {
            foreach ($certificate->GetDocuments() as $dil)
            {
              if($document->id() == $dil->getDocument()->id())
              {
                $has = true;
                break;
              }
            }
          }
          else
          {
            $document = new MrDocument();
          }

          // Документ найден в этом серитфикате - следующая итерация
          if($has)
          {
            continue;
          }
          else
          {
            $document->setName($name_xml ?? null);
            $document->setNumber($number_xml ?? null);
            if(isset($xml->docCreationDate) && ($date_create_xml = (string)$xml->docCreationDate))
            {
              $document->setDate($date_create_xml);
            }

            $document->setKind(MrDocument::KIND_EQUALS);

            // Если есть документ аккредитации - тип аккредитация
            if(isset($xml->accreditationCertificateId) && ($acr_xml = (string)$xml->accreditationCertificateId))
            {
              $document->setAccreditation($acr_xml);
            }

            if(isset($xml->businessEntityName) && ($business_name_xml = (string)$xml->businessEntityName))
            {
              $document->setOrganisation($business_name_xml);
            }

            $document->save_mr();
            $document->reload();


            $new_dil = new MrCertificateDocument();
            $new_dil->setCertificateID($certificate->id());
            $new_dil->setDocumentID($document->id());
            $new_dil->save_mr();
          }
        }
      }
    }

    // Документы, обеспечивающие соблюдение требований
    if(isset($xml_doc->complianceProvidingDocDetails))
    {
      $document_guarantee_xml_list = $xml_doc->complianceProvidingDocDetails;
      foreach ($document_guarantee_xml_list->element as $document_guarantee_xml)
      {
        if(!isset($document_guarantee_xml->docId) && !isset($document_guarantee_xml->docName))
        {
          continue;
        }

        $document = null;

        // Поиск по номеру
        if(isset($document_guarantee_xml->docId) && ($doc_number_xml = (string)$document_guarantee_xml->docId))
        {
          $document = MrDocument::loadBy($doc_number_xml, 'Number');
        }

        // По имени
        if(!$document && (isset($document_guarantee_xml->docName) && ($doc_name_xml = (string)$document_guarantee_xml->docName)))
        {
          $document = MrDocument::loadBy($doc_name_xml, 'Name');
        }

        if($document && $document->getCertificate()->id() == $certificate_id)
        {
          continue;
        }

        // Новый
        if(!$document)
        {
          $document = new MrDocument();
        }

        $document->setCertificateID($certificate_id);
        $document->setKind(MrDocument::KIND_GUARANTEE);
        $document->setNumber($doc_number_xml ?? null);

        if(isset($document_guarantee_xml->docName) && ($doc_name_xml = (string)$document_guarantee_xml->docName))
        {
          $document->setName($doc_name_xml);
        }

        if(isset($document_guarantee_xml->docCreationDate) && ($doc_date = (string)$document_guarantee_xml->docCreationDate))
        {
          $document->setDate($doc_date);
        }

        if(isset($document_guarantee_xml->standardListIndicator) && ($is = (bool)$document_guarantee_xml->standardListIndicator))
        {
          $document->setIsInclude($is);
        }

        $document->save_mr();
        $document->reload();
      }
    }
  }

  /**
   * быстрый парсинг страны
   *
   * @param SimpleXMLElement $xml
   * @return MrCountry|null
   */
  protected
  static function __parsCountry(SimpleXMLElement $xml): ?MrCountry
  {
    if(isset($xml->value) && ($country_code_xml = (string)$xml->value))
    {
      if($country = MrCountry::loadBy($country_code_xml, 'ISO3166alpha2'))
      {
        return $country;
      }
    }

    return null;
  }

  /**
   * Производитель
   *
   * @param SimpleXMLElement $xml
   * @return MrManufacturer|null
   */
  protected
  static function importManufacturer(SimpleXMLElement $xml): ?MrManufacturer
  {
    if(isset($xml->element))
    {
      $manufacturer_xml = $xml->element;

      if(isset($manufacturer_xml->businessEntityName) && ($name_xml = (string)$manufacturer_xml->businessEntityName))
      {
        if(isset($manufacturer_xml->unifiedCountryCode) && ($country = self::__parsCountry($manufacturer_xml->unifiedCountryCode)))
        {
          $manufacturer = MrManufacturer::loadBy($name_xml, 'Name') ?: new MrManufacturer();
          $manufacturer->setName($name_xml);
          $manufacturer->setCountryID($country->id());

          if(isset($manufacturer_xml->addressV4Details))
          {
            $addresses = self::importAddress($manufacturer_xml, $manufacturer);
            foreach ($addresses as $key => $address)
            {
              if($key == MrAddress::ADDRESS_KIND_REGISTRATION)
              {
                $manufacturer->setAddress1ID($address->id());
              }
              elseif($key == MrAddress::ADDRESS_KIND_FACT)
              {
                $manufacturer->setAddress2ID($address->id());
              }
              else
              {
                dd('Тип адреса не известен: ' . $key);
              }
            }
          }

          $manufacturer->save_mr();
          $manufacturer->reload();

          return $manufacturer;
        }
      }
    }

    return null;
  }

  /**
   * Импорт ФИО
   *
   * @param SimpleXMLElement $xml
   * @return MrFio|null
   */
  public
  static function importFio(SimpleXMLElement $xml): ?MrFio
  {
    $fio = null;
    $position_name = null;
    $first_name = null;
    $middle_name = null;
    $last_name = null;
    $xml_old = $xml;

    if(isset($xml->element)) // Эксперт-аудитор
    {
      $xml = $xml->element;
    }
    elseif(isset($xml->fullNameDetails))
    {
      // Должность (есть только в органе по оценке соответствия)
      if(isset($xml->positionName))
      {
        $position_name = (string)$xml->positionName;
      }

      $xml = $xml->fullNameDetails;
    }

    // Имя
    if(isset($xml->firstName))
    {
      $first_name = (string)$xml->firstName;
    }
    // Отчество
    if(isset($xml->middleName))
    {
      $middle_name = (string)$xml->middleName;
    }
    // Фамилия
    if(isset($xml->lastName))
    {
      $last_name = (string)$xml->lastName;
    }

    if($first_name || $middle_name || $last_name || $position_name)
    {
      $fio = new MrFio();

      $fio->setPositionName($position_name);
      $fio->setFirstName($first_name);
      $fio->setMiddleName($middle_name);
      $fio->setLastName($last_name);

      $fio_id = $fio->save_mr();
      $fio->reload();
    }

    if(isset($xml_old->communicationDetails) && isset($fio_id))
    {
      self::importCommunicate($xml_old->communicationDetails, $fio);
    }

    return $fio;
  }

  /**
   * Импорт органа по оценке соответствия
   *
   * @param SimpleXMLElement $xml
   * @return MrConformityAuthority
   */
  public
  static function importConformityAuthority(SimpleXMLElement $xml): ?MrConformityAuthority
  {
    // Номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    if(isset($xml->conformityAuthorityId))
    {
      $authority_id = (string)$xml->conformityAuthorityId;
    }
    else
    {
      return null;
    }

    $conformity = MrConformityAuthority::loadBy($authority_id, 'ConformityAuthorityId') ?: new MrConformityAuthority();

    $conformity->setConformityAuthorityId($authority_id);
    // Страна
    if(isset($xml->unifiedCountryCode) && ($country_xml = (string)$xml->unifiedCountryCode->value))
    {
      if($country = MrCountry::loadBy($country_xml, 'ISO3166alpha2'))
      {
        $conformity->setCountryID($country->id());
      }
    }

    if(isset($xml->docId))
    {
      $conformity->setDocumentNumber((string)$xml->docId);
    }

    if(isset($xml->docCreationDate))
    {
      $conformity->setDocumentDate((string)$xml->docCreationDate);
    }

    if(isset($xml->businessEntityName))
    {
      $conformity->setName((string)$xml->businessEntityName);
    }

    if(isset($xml->officerDetails))
    {
      $officer = self::importFio($xml->officerDetails);
      $conformity->setOfficerDetailsID($officer ? $officer->id() : null);
    }

    $addresses = self::importAddress($xml, $conformity);
    foreach ($addresses as $key => $address)
    {
      if($key == MrAddress::ADDRESS_KIND_REGISTRATION)
      {
        $conformity->setAddress1ID($address->id());
      }
      elseif($key == MrAddress::ADDRESS_KIND_FACT)
      {
        $conformity->setAddress2ID($address->id());
      }
      else
      {
        dd('Тип адреса не известен: ' . $key);
      }
    }

    $conformity_id = $conformity->save_mr();

    return $conformity;
  }

  /**
   * Импорт адреса
   *
   * @param SimpleXMLElement $xml
   * @param object $object
   * @return array
   */
  protected
  static function importAddress(SimpleXMLElement $xml, object $object): array
  {
    $out = array();

    if(isset($xml->addressV4Details))
    {
      $addresses_xml = $xml->addressV4Details->element;

      foreach ($addresses_xml as $address_xml)
      {
        if(isset($address_xml->addressKindCode) && ($address_kind = (int)$address_xml->addressKindCode))
        {
          $address_kind = (int)$address_xml->addressKindCode;
        }
        else
        {
          continue;
        }

        $address = null;

        if($address_kind == MrAddress::ADDRESS_KIND_REGISTRATION)
        {
          $address = $object->getAddress1();
        }
        elseif($address_kind == MrAddress::ADDRESS_KIND_FACT)
        {
          $address = $object->getAddress2();
        }

        if(!$address)
        {
          $address = new MrAddress();
        }

        $address->setAddressKind($address_kind);

        if(isset($address_xml->unifiedCountryCode) && isset($address_xml->unifiedCountryCode->value) && ($country_xml = (string)$address_xml->unifiedCountryCode->value))
        {
          $country = MrCountry::loadBy($country_xml, 'ISO3166alpha2');
          if($country)
          {
            $address->setCountryID($country->id());
          }
          else
          {
            continue;
          }
        }

        // Регион
        if(isset($address_xml->regionName) && ($region = (string)$address_xml->regionName))
        {
          $address->setRegionName($region);
        }

        if(isset($address_xml->districtName) && ($district = (string)$address_xml->districtName))
        {
          $address->setDistrictName($district);
        }


        if(isset($address_xml->cityName) && ($cityName = (string)$address_xml->cityName))
        {
          $address->setCity($cityName);
        }

        if(isset($address_xml->streetName) && ($streetName = (string)$address_xml->streetName))
        {
          $address->setStreetName($streetName);
        }

        if(isset($address_xml->buildingNumberId) && ($buildingNumberId = (string)$address_xml->buildingNumberId))
        {
          $address->setBuildingNumberId($buildingNumberId);
        }

        if(isset($address_xml->postCode) && ($postCode = (string)$address_xml->postCode))
        {
          $address->setPostCode($postCode);
        }


        $address->save_mr();
        $address->reload();

        $out[$address_kind] = $address;
      }
    }

    return $out;
  }

  /**
   * Парсинг самого сертификата
   *
   * @param SimpleXMLElement $xml
   * @param string $link_out
   * @return MrCertificate|null
   */
  protected
  static function importCertificateDetails(SimpleXMLElement $xml, string $link_out): ?MrCertificate
  {
    $certificate = null;

    if(isset($xml->docId) && ($number = (string)$xml->docId))
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
    }
    else
    {
      dd('В сертификате нету номера');
    }

    $certificate->setLinkOut($link_out);

    // Страна
    if(!isset($xml->unifiedCountryCode))
    {
      dd('Страна не указана');
    }

    $country_code_xml = (string)$xml->unifiedCountryCode->value;
    $country = MrCountry::loadBy($country_code_xml, 'ISO3166alpha2');

    if(!$country)
    {
      dd($country_code_xml . ' страна не найдена в справочнике в столбце ISO3166alpha2');
    }

    $certificate->setCountryID($country->id());

    // Номер
    $certificate->setNumber($number ?? null);

    // Дата начала действия сертификата
    if(isset($xml->docStartDate) && ($date_from = (string)$xml->docStartDate))
    {
      $certificate->setDateFrom($date_from);
    }

    // Дата окончания действия
    if(isset($xml->docValidityDate) && ($date_to = (string)$xml->docValidityDate))
    {
      $certificate->setDateTo($date_to);
    }

    // Номер бланка
    if(isset($xml->formNumberId) && ($formNumberId = (string)$xml->formNumberId))
    {
      $certificate->setBlankNumber(strlen($formNumberId) ? $formNumberId : null);
    }

    /**
     * Признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с
     * выдачей сертификатов соответствия и деклараций о соответствии по единой форме:
     * 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
     * */
    if(isset($xml->singleListProductIndicator) && ($singleListProductIndicator = (bool)$xml->singleListProductIndicator))
    {
      $certificate->setSingleListProductIndicator($singleListProductIndicator);
    }

    // Тип документа
    if(isset($xml->conformityDocKindCode) && ($conformityDocKindCode = (string)$xml->conformityDocKindCode))
    {
      if($cert_kind = MrCertificateKind::loadBy($conformityDocKindCode, 'Code'))
      {
        $certificate->setCertificateKindID($cert_kind->id());
      }
      else
      {
        dd('Тип сертификата не известен ' . $xml->conformityDocKindCode);
      }
    }

    //// Статус
    if(isset($xml->docStatusDetails) && ($docStatusDetails = $xml->docStatusDetails))
    {
      if(isset($docStatusDetails->docStatusCode) && ($status_code = (int)$docStatusDetails->docStatusCode))
      {
        $certificate->setStatus($status_code);
      }

      // Начальная дата действия статуса
      if(isset($docStatusDetails->startDate) && ($status_date_from = (string)$docStatusDetails->startDate))
      {
        $certificate->setDateStatusFrom($status_date_from);
      }

      // Конечная дата действия статуса
      if(isset($docStatusDetails->EndDate) && ($status_date_to = (string)$docStatusDetails->EndDate))
      {
        $certificate->setDateStatusTo($status_date_to);
      }
    }

    // Схема сертификации
    if(isset($xml->certificationSchemeCode) && ($schema_certificate = (string)$xml->certificationSchemeCode))
    {
      if(isset($xml->certificationSchemeCode->element) && ($schema_certificate = (string)$xml->certificationSchemeCode->element))
      {
        $certificate->setSchemaCertificate($schema_certificate);
      }
    }

    if(isset($xml->resourceItemStatusDetails) && ($DateUpdateEAES = (string)$xml->resourceItemStatusDetails->updateDateTime))
    {
      $certificate->setDateUpdateEAES($DateUpdateEAES);
    }

    if(isset($xml->fullNameDetails) && ($fio_xml = $xml->fullNameDetails))
    {
      if($fio = self::importFio($fio_xml))
      {
        $certificate->setAuditorID($fio->id());
      }
    }

    return $certificate;
  }

  /**
   * Импорт связь
   *
   * @param SimpleXMLElement $xml
   * @param object $object
   * @return array
   */
  public
  static function importCommunicate(SimpleXMLElement $xml, object $object): array
  {
    if(!$object->GetTableKind())
    {
      dd('Неизвестен объект привязки');
    }

    $out = array();

    if(!isset($xml->element))
    {
      return $out;
    }

    foreach ($xml->element as $item)
    {
      if(isset($item->communicationChannelCode) && ($kind = (string)$item->communicationChannelCode))
      {
        if(!array_search($kind, MrCommunicate::GetKindCodes()))
        {
          dd('Неизвестный тип связи ' . $item->communicationChannelCode);
        }
      }
      else
      {
        dd("Отсутствует тип связи");
      }

      if(isset($item->communicationChannelId) && ($element_xml = $item->communicationChannelId))
      {
        if(isset($kind) && isset($element_xml->element) && ($address_str = (string)$element_xml->element))
        {
          $address_str = str_replace(' ', '', $address_str);
          if($communicate = MrCommunicate::loadBy($address_str, 'Address'))
          {
            $out[$communicate->id()] = $communicate;
            $communicate_id = $communicate->id();
          }
          else
          {
            $communicate = new MrCommunicate();

            $kind_code = array_search($kind, MrCommunicate::GetKindCodes());
            $communicate->setKind($kind_code);
            $communicate->setAddress($address_str);

            $communicate_id = $communicate->save_mr();
            $communicate->reload();
            $out[$communicate_id] = $communicate;
          }

          // поиск дублей в связующей таблице
          if(!MrCommunicateInTable::GetByObject($communicate_id, $object))
          {
            $in_table = new MrCommunicateInTable();
            $in_table->setCommunicateID($communicate_id);
            $in_table->setRowID($object->id());
            $in_table->setTableKind($object->GetTableKind());
            $in_table->save_mr();
            $in_table->reload();
          }
        }
      }
    }
    return $out;
  }
}