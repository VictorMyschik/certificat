<?php


namespace App\Models\Certificate;


use App\Models\ORM;

class MrApplicant extends ORM
{
  public static $mr_table = 'mr_applicant';
  public static $className = MrApplicant::class;
  protected $table = 'mr_applicant';

  protected static $dbFieldsMap = array(
    'CountryID',
    'Name',
    'Address1',
    'Address2',
    'Fio', // Лицо, принявшее сертификат
    'Hash',
  );

  public static function loadBy($value, $field = 'id'): ?MrApplicant
  {
    return parent::loadBy((string)$value, $field);
  }


}