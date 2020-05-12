<?php

namespace App\Models\Certificate;

use App\Helpers\MrDateTime;
use App\Models\MrUser;
use App\Models\Office\MrUserInOffice;
use App\Models\ORM;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificateMonitoring extends ORM
{
  protected $table = 'mr_certificate_monitoring';
  public static $className = MrCertificateMonitoring::class;

  protected static $dbFieldsMap = array(
    'UserInOfficeID',
    'CertificateID',
    'Description',
    //'WriteDate',
  );

  public function before_delete()
  {
    Cache::forget('user_certificate_' . MrUser::me()->id());
  }

  public function getUserInOffice(): MrUserInOffice
  {
    return MrUserInOffice::loadBy($this->UserInOfficeID);
  }

  public function setUserInOfficeID(int $value): void
  {
    $this->UserInOfficeID = $value;
  }

  public function getCertificate(): MrCertificate
  {
    return MrCertificate::loadBy($this->CertificateID);
  }

  public function setCertificateID(int $value): void
  {
    $this->CertificateID = $value;
  }

  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  public function getWriteDate(): MrDateTime
  {
    return MrDateTime::fromValue($this->WriteDate);
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
      $list = DB::table(MrCertificate::getTableName())
        ->join(MrCertificateMonitoring::$mr_table, MrCertificateMonitoring::$mr_table . '.CertificateID', '=', MrCertificate::getTableName() . '.id')
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
    return MrCertificateMonitoring::LoadArray(['UserInOfficeID' => $uio->id()]);
  }
}
