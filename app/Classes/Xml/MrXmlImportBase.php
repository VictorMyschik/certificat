<?php


namespace App\Classes\Xml;


use App\Http\Controllers\Controller;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use SimpleXMLElement;

/**
 * Базовый класс для импорта данных из XML
 */
class MrXmlImportBase extends Controller
{
  /**
   * Импорт ФИО
   *
   * @param SimpleXMLElement $xml
   * @return MrFio|null
   */
  public static function importFio(SimpleXMLElement $xml): ?MrFio
  {
    if($xml->positionName)
    {
      return null;
    }

    $fio = new MrFio();

    $fio->setPositionName((string)$xml->positionName);

    $full_name = $xml->fullNameDetails;

    $fio->setFirstName($full_name->firstName);
    $fio->setMiddleName($full_name->middleName);
    $fio->setLastName($full_name->lastName);

    $fio->save_mr();

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
    $officer = self::importFio($xml->officerDetails);

    //$conformity = new MrConformityAuthority();
    /*//$conformity->setCountryID();
    $conformity->setConformityAuthorityId((string)$xml->conformityAuthorityId);
    $conformity->setDocumentNumber((string)$xml->docId);
    $conformity->setDocumentDate((string)$xml->docCreationDate);
    $conformity->setName((string)$xml->businessEntityName);

    // руководитель

    $conformity->setOfficerDetailsID($officer->id());

    // $conformity->save_mr();
*/
    return null;//$conformity;
  }
}