<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrCertificateMonitoring extends ORM
{
  public static $mr_table = 'mr_certificate_monitoring';
  public static $className = MrCertificateMonitoring::class;
  protected $id = 0;

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

  public function save_mr()
  {
    Cache::forget('user_certificate_' . MrUser::me()->id());
    return parent::mr_save_object($this);
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

  public static function GetByUser(MrUser $user): array
  {
    return MrCertificateMonitoring::LoadArray(Cache::rememberForever('user_certificate_' . $user->id(), function () use ($user) {
      return DB::table(self::$mr_table)
        ->join(MrUserInOffice::$mr_table, MrUserInOffice::$mr_table . '.id', '=', self::$mr_table . '.UserInOfficeID')
        ->join(MrUser::$mr_table, MrUser::$mr_table . '.id', '=', MrUserInOffice::$mr_table . '.UserID')
        ->where(MrUser::$mr_table . '.id', '=', $user->id())
        ->get(array_merge(array(self::$mr_table . '.id'), MrCertificateMonitoring::$dbFieldsMap));
    }
    ), MrCertificateMonitoring::class);
  }

}
