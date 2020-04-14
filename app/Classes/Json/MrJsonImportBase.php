<?php


namespace App\Classes\Json;


use App\Http\Controllers\Controller;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\References\MrCountry;

class MrJsonImportBase extends Controller
{
  /**
   * Импорт ФИО
   *
   * @param array $data
   * @return MrFio|null
   */
  public static function importFio(array $data): ?MrFio
  {
    if(!$data['positionName'])
    {
      return null;
    }

    $fio = new MrFio();

    $fio->setPositionName((string)$data['positionName']);

    $full_name = $data['fullNameDetails'];

    $fio->setFirstName($full_name['firstName']);
    $fio->setMiddleName($full_name['middleName']);
    $fio->setLastName($full_name['lastName']);

    $fio->save_mr();

    return $fio;
  }

  /**
   * Импорт органа по оценке соответствия
   *
   * @param array $data
   * @param MrCountry $country
   * @return MrConformityAuthority
   */
  public static function importConformityAuthority(array $data, MrCountry $country)
  {


    $conformity = new MrConformityAuthority();
    $conformity->setCountryID($country->id());
    $conformity->setConformityAuthorityId((string)$data['conformityAuthorityId']);
    $conformity->setDocumentNumber((string)$data['docId']);
    $conformity->setDocumentDate((string)$data['docCreationDate']);
    $conformity->setName((string)$data['businessEntityName']);

    if($officer = self::importFio($data['officerDetails']))
    {
      $conformity->setOfficerDetailsID($officer->id());
    }

    $conformity->save_mr();

    return $conformity;
  }
}