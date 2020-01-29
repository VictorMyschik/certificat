<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificateMonitoring extends ORM
{
  public static $mr_table = 'mr_certificate_monitoring';
  public static $className = MrCertificateMonitoring::class;

  protected static $dbFieldsMap = array(
    'UserInOfficeID',
    'CertificateID',
    'Description',
    //'WriteDate',
  );

  public static function loadBy($value, $field = 'id'): ?MrCertificateMonitoring
  {
    return parent::loadBy((string)$value, $field);
  }

  public function before_delete()
  {
    Cache::forget('user_certificate_' . MrUser::me()->id());
  }

  public function getUserInOffice(): MrUserInOffice
  {
    return MrUserInOffice::loadBy($this->UserInOfficeID);
  }

  public function setUserInOfficeID(int $value)
  {
    $this->UserInOfficeID = $value;
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value)
  {
    $this->CertificateID = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  public function getWriteDate(): MtDateTime
  {
    return MtDateTime::fromValue($this->WriteDate);
  }

/////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Список сертификатов, загруженных пользователем
   *
   * @param MrUserInOffice $user_in_office
   * @return MrCertificate[]
   */
  public static function GetUserCertificateMonitoringList(MrUserInOffice $user_in_office): array
  {
    return Cache::rememberForever('user_certificate_' . $user_in_office->id(), function () use ($user_in_office) {
      $list = DB::table(MrCertificate::$mr_table)
        ->join(MrCertificateMonitoring::$mr_table, MrCertificateMonitoring::$mr_table . '.CertificateID', '=', MrCertificate::$mr_table . '.id')
        ->where(MrCertificateMonitoring::$mr_table . '.UserInOfficeID', '=', $user_in_office->id())
        ->get()->toArray();

      if(count($list))
      {
        return $list;
      }
      else
      {
        return array();
      }
    });
  }

  /**
   * @param MrUserInOffice $uio
   * @return MrCertificateMonitoring[]
   */
  public static function GetByUserInOffice(MrUserInOffice $uio)
  {
    $list = DB::table(self::$mr_table)->where('UserInOfficeID' , '=', $uio->id())->get();
    return parent::LoadArray($list, MrCertificateMonitoring::class);
  }
}
