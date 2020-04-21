<?php


namespace App\Classes\Xml;


use App\Http\Controllers\Controller;
use App\Models\Certificate\MrAddress;
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

    // Сведения об органе по оценке соответствия
    $conformity_authority = self::importConformityAuthority($xml->conformityAuthorityV2Details);

    if($conformity_authority)
    {
      $certificate->setAuthorityID($conformity_authority->id());
    }

    $certificate->save_mr();
    $certificate->reload();

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
    $position_name = null;
    $first_name = null;
    $middle_name = null;
    $last_name = null;

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

      $fio->save_mr();
      $fio->reload();
    }

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
    // Номер органа по оценке соответствия в национальной части единого реестра органов по оценке соответствия
    $authority_id = (string)$xml->conformityAuthorityId;
    $conformity = MrConformityAuthority::loadBy($authority_id, 'ConformityAuthorityId') ?: new MrConformityAuthority();

    $conformity->setConformityAuthorityId($authority_id);
    // Страна
    $country_xml = (string)$xml->unifiedCountryCode->value;
    if($country = MrCountry::loadBy($country_xml, 'ISO3166alpha2'))
    {
      $conformity->setCountryID($country->id());
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

    $addresses = self::ImportAddress($xml, $conformity);
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

    $conformity->save_mr();

    return $conformity;
  }

  /**
   * Импорт адреса
   * @param SimpleXMLElement $xml
   * @param MrConformityAuthority $authority
   * @return MrAddress|null
   */
  protected static function ImportAddress(SimpleXMLElement $xml, MrConformityAuthority $authority): array
  {
    $out = array();

    if(isset($xml->addressV4Details))
    {
      $addresses_xml = $xml->addressV4Details->element;

      foreach ($addresses_xml as $address_xml)
      {
        $address_kind = (int)$address_xml->addressKindCode;

        if($address_kind == MrAddress::ADDRESS_KIND_REGISTRATION)
        {
          $address = $authority->getAddress1();
        }
        elseif($address_kind == MrAddress::ADDRESS_KIND_FACT)
        {
          $address = $authority->getAddress2();
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
            dd('Страна органа по сетртификации не опознана ' . $country_xml);
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
    $certificate->setDateStatusFrom($status_date_from);
    // Конечная дата действия статуса
    $status_date_to = (string)$docStatusDetails->EndDate;
    $certificate->setDateStatusTo($status_date_to);

    // Схема сертификации
    $schema_certificate = (string)$xml->certificationSchemeCode->element;
    $certificate->setSchemaCertificate($schema_certificate);

    $DateUpdateEAES = (string)$xml->resourceItemStatusDetails->updateDateTime;
    $certificate->setDateUpdateEAES($DateUpdateEAES);

    if($fio_xml = $xml->fullNameDetails)
    {
      if($fio = self::importFio($fio_xml))
      {
        $certificate->setAuditorID($fio->id());
      }
    }

    return $certificate;
  }
}