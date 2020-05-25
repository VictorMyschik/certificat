<?php

namespace App\Classes\Xml;

use App\Http\Controllers\Controller;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrApplicant;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrDocument;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use App\Models\Certificate\MrProduct;
use App\Models\Certificate\MrProductInfo;
use App\Models\Certificate\MrTnved;
use App\Models\Lego\MrCertificateDocument;
use App\Models\Lego\MrCommunicateInTable;
use App\Models\References\MrCertificateKind;
use App\Models\References\MrCountry;
use App\Models\References\MrTechnicalRegulation;
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
    if (isset($xml->entry))
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
    if (!$certificate)
    {
      return null;
    }

    $certificate->save_mr();
    $certificate->reload();

    //// Сведения об органе по оценке соответствия
    if (isset($xml->conformityAuthorityV2Details))
    {
      if ($conformity_authority = self::importConformityAuthority($xml->conformityAuthorityV2Details))
      {
        $certificate->setAuthorityID($conformity_authority->id());
      }
    }

    //// Производитель и всё что связано с товаром
    if (isset($xml->technicalRegulationObjectDetails))
    {
      $tech_regulation = $xml->technicalRegulationObjectDetails;

      // Производитель
      if (isset($tech_regulation->manufacturerDetails))
      {
        $manufacturer = self::importManufacturer($tech_regulation->manufacturerDetails);

        if ($manufacturer)
        {
          $certificate->setManufacturerID($manufacturer->id());
        }

        //// Товары
        if (isset($tech_regulation->productDetails) && ($product_details_xml = $tech_regulation->productDetails))
        {
          self::importProducts($product_details_xml, $manufacturer, $certificate);
        }
      }

      // Тип технического регулирования
      if (isset($tech_regulation->technicalRegulationObjectKindCode) && ($technical_regulation_kind_xml = (string)$tech_regulation->TechnicalRegulationObjectKindCode))
      {
        if ($regulation_kind = MrTechnicalRegulation::loadBy($technical_regulation_kind_xml, 'Code'))
        {
          $certificate->setTechnicalRegulationKindID($regulation_kind->id());
        }
        else
        {
          dump($tech_regulation);
          dd('Неизвестный код типа технического регулирования: ' . $technical_regulation_kind_xml);
        }
      }
      elseif (isset($tech_regulation->technicalRegulationObjectKindName) && ($technical_regulation_kind_name_xml = (string)$tech_regulation->technicalRegulationObjectKindName))
      {
        if ($regulation_kind = MrTechnicalRegulation::loadBy($technical_regulation_kind_name_xml, 'Name'))
        {
          $certificate->setTechnicalRegulationKindID($regulation_kind->id());
        }
        else
        {
          dump($tech_regulation);
          dd('Неизвестное наименование типа технического регулирования: ' . $technical_regulation_kind_name_xml);
        }
      }

      //Реквизиты товаросопроводительной документации
      if (isset($tech_regulation->docInformationDetails) && ($product_documents_xml = $tech_regulation->docInformationDetails))
      {
        self::importDocument($product_documents_xml, $certificate);
      }
    }
    //dd($xml);
    $certificate->save_mr();
    $certificate->reload();

    // Документы
    if (isset($xml->complianceDocDetails) || isset($xml->DocInformationDetails))
    {
      self::importDocument($xml, $certificate);
    }

    // Заявитель
    if (isset($xml->applicantDetails))
    {
      self::importApplicant($xml->applicantDetails, $certificate);
    }

    return $certificate;
  }

  /**
   * Импорт документов, привязанных к сертификату
   *
   * @param SimpleXMLElement $xml_doc
   * @param MrCertificate $certificate
   * @param int $kind к чему относится документ
   */
  protected static function importDocument(SimpleXMLElement $xml_doc, MrCertificate $certificate): void
  {
    // Документы, подтверждающие соответствие требованиям
    if (isset($xml_doc->complianceDocDetails))
    {
      $xml_doc_equals = $xml_doc->complianceDocDetails;

      if (isset($xml_doc_equals->element))
      {
        foreach ($xml_doc_equals->element as $xml)
        {
          $hash_name = '';

          if (isset($xml->docId) && ($number_xml = (string)$xml->docId))
          {
            $hash_name = '|' . $number_xml;
          }

          if (isset($xml->docName) && ($name_xml = (string)$xml->docName))
          {
            $hash_name = '|' . $name_xml;
          }

          if (isset($xml->docCreationDate) && ($date_xml = (string)$xml->docCreationDate))
          {
            $hash_name = '|' . $date_xml;
          }

          if (isset($xml->accreditationCertificateId) && ($accr_xml = (string)$xml->accreditationCertificateId))
          {
            $hash_name = '|' . $accr_xml;
          }

          if (isset($xml->businessEntityName) && ($business_xml = (string)$xml->businessEntityName))
          {
            $hash_name = '|' . $business_xml;
          }

          if ($hash_name == "Нет данных|0001-01-01T00:00:00")
          {
            continue;
          }

          if (strlen($hash_name))
          {
            $hash = md5($hash_name);

            $document = MrDocument::loadBy($hash, 'Hash') ?: new MrDocument();
            $document->setKind(MrDocument::KIND_EQUALS);
            $document->setName($name_xml ?? null);
            $document->setNumber($number_xml ?? null);
            $document->setDate($date_xml ?? null);
            // Если есть документ аккредитации - тип аккредитация
            $document->setAccreditation($accr_xml ?? null);
            $document->setOrganisation($business_xml ?? null);
            $document->setHash($hash);

            $document->save_mr();
            $document->reload();

            /// Поиск дубликатов
            $has = false;
            foreach ($certificate->GetDocuments() as $dil)
            {
              if ($document->id() == $dil->getDocument()->id())
              {
                $has = true;
                break;
              }
            }

            // Документ найден в этом сертификате - следующая итерация
            if (!$has)
            {
              $new_dil = new MrCertificateDocument();
              $new_dil->setCertificateID($certificate->id());
              $new_dil->setDocumentID($document->id());
              $new_dil->save_mr();
            }
          }
        }
      }
    }


    // Документы, обеспечивающие соблюдение требований
    if (isset($xml_doc->complianceProvidingDocDetails))
    {
      $document_guarantee_xml_list = $xml_doc->complianceProvidingDocDetails;
      foreach ($document_guarantee_xml_list->element as $document_guarantee_xml)
      {
        $hash_name = '';

        if (!isset($document_guarantee_xml->docId) && !isset($document_guarantee_xml->docName))
        {
          continue;
        }

        // Номер документа
        if (isset($document_guarantee_xml->docId))
        {
          if ($doc_number_xml = (string)$document_guarantee_xml->docId)
          {
            $hash_name .= $doc_number_xml;
          }
        }

        if (isset($document_guarantee_xml->docName))
        {
          if ($doc_name_xml = (string)$document_guarantee_xml->docName)
          {
            $hash_name .= '|' . $doc_name_xml;
          }
        }

        if (isset($document_guarantee_xml->docCreationDate))
        {
          if ($doc_date_xml = (string)$document_guarantee_xml->docCreationDate)
          {
            $hash_name .= '|' . $doc_date_xml;
          }
        }

        if (isset($document_guarantee_xml->standardListIndicator))
        {
          if ($doc_indicator_xml = (string)$document_guarantee_xml->standardListIndicator)
          {
            $hash_name .= '|' . $doc_indicator_xml;
          }
        }

        if ($hash_name == "Нет данных|0001-01-01T00:00:00")
          continue;

        if (strlen($hash_name))
        {

          $hash = md5($hash_name);

          $document = MrDocument::loadBy($hash, 'Hash') ?: new MrDocument();

          $document->setKind(MrDocument::KIND_GUARANTEE);
          $document->setNumber($doc_number_xml ?? null);
          $document->setName($doc_name_xml ?? null);
          $document->setDate($doc_date_xml ?? null);
          $document->setIsInclude($doc_indicator_xml ?? null);
          $document->setHash($hash);

          $document->save_mr();
          $document->reload();

          /// Поиск дубликатов
          $has = false;
          foreach ($certificate->GetDocuments() as $dil)
          {
            if ($document->id() == $dil->getDocument()->id())
            {
              $has = true;
              break;
            }
          }

          // Документ найден в этом сертификате - следующая итерация
          if (!$has)
          {
            $new_dil = new MrCertificateDocument();
            $new_dil->setCertificateID($certificate->id());
            $new_dil->setDocumentID($document->id());
            $new_dil->save_mr();
          }
        }
      }
    }


    // Реквизиты товаросопроводительной документации
    // Информация о документе, в соответствии с которым изготовлена продукция
    if (isset($xml_doc->element))
    {
      foreach ($xml_doc->element as $xml)
      {
        $hash_name = '';

        if (isset($xml->docId) && ($number_xml = (string)$xml->docId))
          $hash_name .= $number_xml;

        if (isset($xml->docName) && ($name_xml = (string)$xml->docName))
          $hash_name .= '|' . $name_xml;

        if (isset($xml->docCreationDate) && ($date_xml = (string)$xml->docCreationDate))
          $hash_name .= '|' . $date_xml;

        if ($hash_name == "Нет данных|0001-01-01T00:00:00")
          continue;

        if (strlen($hash_name))
        {
          $hash = md5($hash_name);
          $document = MrDocument::loadBy($hash, 'Hash') ?: new MrDocument();

          $document->setKind(MrDocument::KIND_COMMON_GOOD);
          $document->setName($name_xml ?? null);
          $document->setNumber($doc_number_xml ?? null);
          $document->setDate($doc_date_xml ?? null);
          $document->setIsInclude(null);
          $document->setHash($hash);

          $document->save_mr();
          $document->reload();

          /// Поиск дубликатов
          $has = false;
          foreach ($certificate->GetDocuments() as $dil)
          {
            if ($document->id() == $dil->getDocument()->id())
            {
              $has = true;
              break;
            }
          }

          // Документ найден в этом сертификате - следующая итерация
          if (!$has)
          {
            $new_dil = new MrCertificateDocument();
            $new_dil->setCertificateID($certificate->id());
            $new_dil->setDocumentID($document->id());
            $new_dil->save_mr();
          }
        }
      }
    }
  }

  /**
   * Быстрый парсинг страны
   *
   * @param SimpleXMLElement $xml
   * @return MrCountry|null
   */
  protected static function __parsCountry(?SimpleXMLElement $xml): ?MrCountry
  {
    if (!$xml)
    {
      return null;
    }

    if (isset($xml->value) && ($country_code_xml = (string)$xml->value))
    {
      if ($country = MrCountry::loadBy($country_code_xml, 'ISO3166alpha2'))
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
  protected static function importManufacturer(SimpleXMLElement $xml): ?MrManufacturer
  {
    if (!isset($xml->element))
    {
      return null;
    }

    $manufacturer_xml = $xml->element;
    if (isset($manufacturer_xml->businessEntityName) && ($name_xml = (string)$manufacturer_xml->businessEntityName))
    {
      $manufacturer = MrManufacturer::loadBy($name_xml, 'Name') ?: new MrManufacturer();
      $manufacturer->setName($name_xml);

      if (isset($manufacturer_xml->unifiedCountryCode) && ($country = self::__parsCountry($manufacturer_xml->unifiedCountryCode)))
      {
        $manufacturer->setCountryID($country->id());
      }

      if (isset($manufacturer_xml->addressV4Details))
      {
        $addresses = self::importAddress($manufacturer_xml, $manufacturer);

        $manufacturer->setAddress1ID(null);
        $manufacturer->setAddress2ID(null);

        foreach ($addresses as $key => $address)
        {
          if ($key == MrAddress::ADDRESS_KIND_REGISTRATION)
          {
            $manufacturer->setAddress1ID($address->id());
          }
          elseif ($key == MrAddress::ADDRESS_KIND_FACT)
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

    return null;
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
    $position_name = null;
    $first_name = null;
    $middle_name = null;
    $last_name = null;
    $xml_old = $xml;

    if (isset($xml->element)) // Эксперт-аудитор
    {
      $xml = $xml->element;
    }
    elseif (isset($xml->fullNameDetails))
    {
      // Должность (есть только в органе по оценке соответствия)
      if (isset($xml->positionName))
      {
        $position_name = (string)$xml->positionName;
      }

      $xml = $xml->fullNameDetails;
    }

    // Имя
    if (isset($xml->firstName))
    {
      $first_name = (string)$xml->firstName;
    }
    // Отчество
    if (isset($xml->middleName))
    {
      $middle_name = (string)$xml->middleName;
    }
    // Фамилия
    if (isset($xml->lastName))
    {
      $last_name = (string)$xml->lastName;
    }

    if ($first_name || $middle_name || $last_name || $position_name)
    {
      $hash_name = $first_name . '|' . $middle_name . '|' . $last_name . '|' . $position_name;
      $hash = md5($hash_name);
      $fio = MrFio::loadBy($hash, 'Hash') ?: new MrFio();

      $fio->setPositionName($position_name);
      $fio->setFirstName($first_name);
      $fio->setMiddleName($middle_name);
      $fio->setLastName($last_name);
      $fio->setHash($hash);

      $fio_id = $fio->save_mr();
      $fio->reload();
    }

    if (isset($xml_old->communicationDetails) && isset($fio_id))
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
  public static function importConformityAuthority(SimpleXMLElement $xml): ?MrConformityAuthority
  {
    // Номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    if (!isset($xml->conformityAuthorityId))
    {
      return null;
    }

    $authority_id = (string)$xml->conformityAuthorityId;
    $conformity = MrConformityAuthority::loadBy($authority_id, 'ConformityAuthorityId') ?: new MrConformityAuthority();

    $conformity->setConformityAuthorityId($authority_id);

    // Страна
    if (isset($xml->unifiedCountryCode) && ($country = self::__parsCountry($xml->unifiedCountryCode)))
    {
      $conformity->setCountryID($country->id());
    }

    if (isset($xml->docId))
    {
      $conformity->setDocumentNumber((string)$xml->docId);
    }

    if (isset($xml->docCreationDate))
    {
      $conformity->setDocumentDate((string)$xml->docCreationDate);
    }

    if (isset($xml->businessEntityName))
    {
      $conformity->setName((string)$xml->businessEntityName);
    }

    if (isset($xml->officerDetails) && ($officer = self::importFio($xml->officerDetails)))
    {

      $conformity->setOfficerDetailsID($officer->id());
    }

    /// Адрес
    $addresses = self::importAddress($xml, $conformity);
    $conformity->setAddress1ID(null);
    $conformity->setAddress2ID(null);
    foreach ($addresses as $key => $address)
    {
      if ($key == MrAddress::ADDRESS_KIND_REGISTRATION)
      {
        $conformity->setAddress1ID($address->id());
      }
      elseif ($key == MrAddress::ADDRESS_KIND_FACT)
      {
        $conformity->setAddress2ID($address->id());
      }
      else
      {
        dd('Тип адреса не известен: ' . $key);
      }
    }

    $conformity->save_mr();
    $conformity->reload();

    return $conformity;
  }

  /**
   * Импорт адреса
   *
   * @param SimpleXMLElement $xml
   * @param object $object
   * @return array
   */
  protected static function importAddress(SimpleXMLElement $xml, object $object): array
  {
    $out = array();

    if ($object instanceof MrApplicant)
    {
      if (isset($xml->subjectAddressDetails))
      {
        $address_arr_xml = $xml->subjectAddressDetails->element;
      }
    }
    elseif (isset($xml->addressV4Details))
    {
      $address_arr_xml = $xml->addressV4Details->element;
    }

    if (!isset($address_arr_xml))
    {
      dump($xml);
      dd('Отсутствует адрес');
    }

    foreach ($address_arr_xml as $address_xml)
    {
      if (!isset($address_xml->addressKindCode) || !($address_kind = (int)$address_xml->addressKindCode))
      {
        dump($xml);
        dd('Отсутствует тип адреса');
      }

      $address_kind = (int)$address_xml->addressKindCode;

      $hash_name = '';

      if (isset($address_xml->unifiedCountryCode) && isset($address_xml->unifiedCountryCode->value) && ($country_xml = (string)$address_xml->unifiedCountryCode->value))
      {
        $country = MrCountry::loadBy($country_xml, 'ISO3166alpha2');
        $hash_name .= '|' . $country->id();
      }

      // Регион
      if (isset($address_xml->regionName))
      {
        if ($region = (string)$address_xml->regionName)
        {
          $hash_name .= '|' . $region;
        }
      }

      if (isset($address_xml->districtName))
      {
        if ($district = (string)$address_xml->districtName)
        {
          $hash_name .= '|' . $district;
        }
      }

      if (isset($address_xml->cityName))
      {
        if ($cityName = (string)$address_xml->cityName)
        {
          $hash_name .= '|' . $cityName;
        }
      }

      if (isset($address_xml->streetName))
      {
        if ($streetName = (string)$address_xml->streetName)
        {
          $hash_name .= '|' . $streetName;
        }
      }

      if (isset($address_xml->buildingNumberId))
      {
        if ($buildingNumberId = (string)$address_xml->buildingNumberId)
        {
          $hash_name .= '|' . $buildingNumberId;
        }
      }

      if (isset($address_xml->postCode))
      {
        if ($postCode = (string)$address_xml->postCode)
        {
          $hash_name .= '|' . $postCode;
        }
      }

      if (isset($address_xml->addressText))
      {
        if ($address_text = (string)$address_xml->addressText)
        {
          $hash_name .= '|' . $address_text;
        }
      }

      if (!strlen($hash_name))
      {
        continue;
      }

      $hash = md5($hash_name);

      $address = MrAddress::loadBy($hash, 'Hash') ?: new MrAddress();

      $address->setCountryID($country->id());
      $address->setRegionName($region ?? null);
      $address->setDistrictName($district ?? null);
      $address->setCity($cityName ?? null);
      $address->setStreetName($streetName ?? null);
      $address->setBuildingNumberId($buildingNumberId ?? null);
      $address->setPostCode($postCode ?? null);
      $address->setAddressText($address_text ?? null);
      $address->setHash($hash);

      $address->save_mr();
      $address->reload();

      $out[$address_kind] = $address;
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
  protected static function importCertificateDetails(SimpleXMLElement $xml, string $link_out): ?MrCertificate
  {
    $certificate = null;

    if (isset($xml->docId) && ($number = (string)$xml->docId))
    {
      $number = (string)$xml->docId;

      // Проверка, есть такой номер сертификата или нет
      if (isset(MrCertificate::GetHashedList()[$number]))
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
    if ($country = self::__parsCountry($xml->unifiedCountryCode ?? null))
    {
      $certificate->setCountryID($country->id());
    }
    else
    {
      dd('Страна не найдена в справочнике стран по столбцу ISO3166alpha2: ' . (string)$xml->unifiedCountryCode);
    }

    // Номер
    $certificate->setNumber($number);

    // Дата начала действия сертификата
    if (isset($xml->docStartDate) && ($date_from = (string)$xml->docStartDate))
    {
      $certificate->setDateFrom($date_from);
    }

    // Дата окончания действия
    if (isset($xml->docValidityDate) && ($date_to = (string)$xml->docValidityDate))
    {
      $certificate->setDateTo($date_to);
    }

    // Номер бланка
    if (isset($xml->formNumberId) && ($formNumberId = (string)$xml->formNumberId))
    {
      $certificate->setBlankNumber(strlen($formNumberId) ? $formNumberId : null);
    }

    /**
     * Признак включения продукции в единый перечень продукции, подлежащей обязательному подтверждению соответствия с
     * выдачей сертификатов соответствия и деклараций о соответствии по единой форме:
     * 1 – продукция включена в единый перечень; 0 – продукция исключена из единого перечня
     * */
    if (isset($xml->singleListProductIndicator) && ($singleListProductIndicator = (bool)$xml->singleListProductIndicator))
    {
      $certificate->setSingleListProductIndicator($singleListProductIndicator);
    }

    // Тип документа
    if (isset($xml->conformityDocKindCode) && ($conformityDocKindCode_xml = (string)$xml->conformityDocKindCode))
    {
      if ($cert_kind = MrCertificateKind::loadBy($conformityDocKindCode_xml, 'Code'))
      {
        $certificate->setCertificateKindID($cert_kind->id());
      }
      else
      {
        dd('Тип сертификата не известен ' . $xml->conformityDocKindCode);
      }
    }

    //// Статус
    if (isset($xml->docStatusDetails) && ($docStatusDetails = $xml->docStatusDetails))
    {
      if (isset($docStatusDetails->docStatusCode) && ($status_code = (int)$docStatusDetails->docStatusCode))
      {
        $certificate->setStatus($status_code);
      }

      // Начальная дата действия статуса
      if (isset($docStatusDetails->startDate) && ($status_date_from = (string)$docStatusDetails->startDate))
      {
        $certificate->setDateStatusFrom($status_date_from);
      }

      // Конечная дата действия статуса
      if (isset($docStatusDetails->EndDate) && ($status_date_to = (string)$docStatusDetails->EndDate))
      {
        $certificate->setDateStatusTo($status_date_to);
      }
    }

    // Схема сертификации
    if (isset($xml->certificationSchemeCode) && ($schema_certificate_xml = $xml->certificationSchemeCode))
    {
      if (isset($schema_certificate_xml->element) && ($schema_certificate = (string)$schema_certificate_xml->element))
      {
        $certificate->setSchemaCertificate($schema_certificate);
      }
    }

    if (isset($xml->resourceItemStatusDetails) && ($DateUpdateEAES = (string)$xml->resourceItemStatusDetails->updateDateTime))
    {
      $certificate->setDateUpdateEAES($DateUpdateEAES);
    }

    if (isset($xml->fullNameDetails) && ($fio_xml = $xml->fullNameDetails))
    {
      if ($fio = self::importFio($fio_xml))
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
   * @param object $object К чему привязан
   * @return array
   */
  public static function importCommunicate(SimpleXMLElement $xml, object $object): array
  {
    if (!$object->GetTableKind())
    {
      dd('Неизвестен объект привязки');
    }

    $out = array();

    if (!isset($xml->element))
    {
      return $out;
    }

    foreach ($xml->element as $item)
    {
      if (isset($item->communicationChannelCode) && ($kind = (string)$item->communicationChannelCode))
      {
        if (!array_search($kind, MrCommunicate::GetKindCodes()))
        {
          dd('Неизвестный тип связи ' . $item->communicationChannelCode);
        }
      }
      else
      {
        dd("Отсутствует тип связи");
      }

      if (isset($item->communicationChannelId) && ($element_xml = $item->communicationChannelId))
      {
        if (isset($kind) && isset($element_xml->element) && ($address_str = (string)$element_xml->element))
        {
          $address_str = str_replace(' ', '', $address_str);

          $communicate = MrCommunicate::loadBy($address_str, 'Address') ?: new MrCommunicate();
          $communicate->setKind(array_search($kind, MrCommunicate::GetKindCodes()));
          $communicate->setAddress($address_str);

          $communicate->save_mr();
          $communicate->reload();

          $out[$communicate->id()] = $communicate;


          // поиск дублей в связующей таблице
          if (!MrCommunicateInTable::GetByObject($communicate->id(), $object))
          {
            $in_table = new MrCommunicateInTable();
            $in_table->setCommunicateID($communicate->id());
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

  /**
   * Заявитель
   *
   * @param SimpleXMLElement $xml
   * @param MrCertificate $certificate
   */
  protected static function importApplicant(SimpleXMLElement $xml, MrCertificate $certificate): void
  {
    $name_xml = isset($xml->businessEntityName) && strlen((string)$xml->businessEntityName) ? (string)$xml->businessEntityName : '';
    $applicant_id_xml = isset($xml->businessEntityId) && strlen((string)$xml->businessEntityId->value) ? (string)$xml->businessEntityId->value : '';
    $country_code = isset($xml->unifiedCountryCode) && ($country = self::__parsCountry($xml->unifiedCountryCode)) ? $country->getISO3166alpha2() : '';

    if (!strlen($name_xml . $applicant_id_xml . $country_code))
    {
      dump($xml);
      dd('Заявитель не заполнен');
    }

    if (!$country_code)
    {
      dd('Сертификат ID' . $certificate->id() . ' нет страны заявителя');
    }

    $hash_name = $name_xml . '|' . $country_code . '|' . $applicant_id_xml;
    $hash = md5($hash_name);

    $applicant = MrApplicant::loadBy($hash, 'Hash') ?: new MrApplicant();

    $applicant->setName($name_xml ?: null);
    $applicant->setBusinessEntityId($applicant_id_xml ?: null);
    $applicant->setCountryID($country ? $country->id() : null);
    $applicant->setHash($hash);

    $applicant->save_mr();
    $applicant->reload();

    $certificate->setApplicantID($applicant->id());
    $certificate->save_mr();

    $addresses = self::importAddress($xml, $applicant);
    $applicant->setAddress1ID(null);
    $applicant->setAddress2ID(null);
    foreach ($addresses as $key => $address)
    {
      if ($key == MrAddress::ADDRESS_KIND_REGISTRATION)
      {
        $applicant->setAddress1ID($address->id());
      }
      elseif ($key == MrAddress::ADDRESS_KIND_FACT)
      {
        $applicant->setAddress2ID($address->id());
      }
      else
      {
        dd('Тип адреса не известен: ' . $key);
      }
    }

    if (isset($xml->communicationDetails) && isset($applicant))
    {
      self::importCommunicate($xml->communicationDetails, $applicant);
    }

    $applicant->save_mr();
    $applicant->reload();
  }

  /**
   * Импорт товаров
   *
   * @param SimpleXMLElement $xml
   * @param MrManufacturer $manufacturer
   * @param MrCertificate $certificate
   */
  protected static function importProducts(SimpleXMLElement $xml, MrManufacturer $manufacturer, MrCertificate $certificate): void
  {
    // Продукт
    foreach ($xml->element as $item_xml)
    {
      // Наименование
      if (isset($item_xml->productName) && ($product_name_xml = (string)$item_xml->productName))
      {
        if (!$product = MrProduct::loadBy($product_name_xml, 'Name'))
        {
          $product = new MrProduct();
        }

        // Примечание
        if (isset($item_xml->productText) && ($description_xml = (string)$item_xml->productText))
        {
          $product->setDescription($description_xml);
        }

        $product->setManufacturerID($manufacturer->id());
        $product->setName($product_name_xml);
        if (isset($item_xml->commodityCode) && ($product_tnved_xml = $item_xml->commodityCode))
        {
          if (isset($product_tnved_xml->element) && $tnved_xml = (string)$product_tnved_xml->element)
          {
            if ($tnved = MrTnved::loadBy($tnved_xml, 'Code'))
            {
              $product->setTnved($tnved->id());
            }
            else
            {
              $tnved = new MrTnved();
              $tnved->setCode($tnved_xml);
              $tnved->save_mr();
              $tnved->reload();
              $product->setTnved($tnved->id());
            }
          }
        }

        $product->save_mr();
        $product_tnved_xml = null;


        // Сведения о единице продукта
        if (isset($product) && isset($item_xml->productInstanceDetails) && ($product_info_xml =
                $item_xml->productInstanceDetails))
        {
          foreach ($product_info_xml->element as $info_xml)
          {
            $productInstanceId_xml = null;
            // Марка, модель...
            if (isset($info_xml->productInstanceId))
            {
              $productInstanceId_xml = (string)$info_xml->productInstanceId;
            }

            $product_info = MrProductInfo::loadBy($productInstanceId_xml, 'InstanceId') ?: new MrProductInfo();
            $product_info->setProductID($product->id());

            $product_info->setInstanceId($productInstanceId_xml);
            // Код ТН ВЭД
            if (isset($item_xml->commodityCode) && ($tnved_xml = (string)$item_xml->commodityCode))
            {
              if ($tnved = MrTnved::loadBy($tnved_xml, 'Code'))
              {
                $product_info->setTnved($tnved->id());
              }
              else
              {
                $tnved = new MrTnved();
                $tnved->setCode($tnved_xml);
                $tnved->save_mr();
                $tnved->reload();

                $product_info->setTnved($tnved->id());
              }
            }

            // Дата изготовления
            if (isset($info_xml->ProductInstanceManufacturedDate) && ($manufacturer_date_xml = $info_xml->ProductInstanceManufacturedDate))
            {
              $product_info->setManufacturedDate($manufacturer_date_xml);
            }

            // Срок годности
            if (isset($info_xml->ProductInstanceExpiryDate) && ($expiryr_date_xml = $info_xml->ProductInstanceExpiryDate))
            {
              $product_info->setExpiryDate($expiryr_date_xml);
            }

            // Прочее описание продукта
            if (isset($info_xml->ProductText) && ($description_xml = $info_xml->ProductText))
            {
              $product_info->setDescription($description_xml);
            }

            // Наименование
            if (isset($info_xml->ProductName) && ($name_xml = $info_xml->ProductName))
            {
              $product_info->setName($name_xml);
            }

            ///TODO сделать количество и ед измерение

            if ($product_info->getName() || $product_info->getDescription() || $product_info->getTnved() || $product_info->getInstanceId() || $product_info->getManufacturedDate() || $product_info->getExpiryDate())
            {
              $product_info->save_mr();
            }
          }
        }
      }

      //// Документы
      if (isset($item_xml->docInformationDetails))
      {
        foreach ($item_xml->docInformationDetails->element as $doc_xml)
        {
          self::importDocument($doc_xml, $certificate, MrDocument::KIND_GOOD);
        }
      }
    }
  }
}