<?php

namespace App\Models\Office;

use App\Helpers\MrDateTime;
use App\Models\Certificate\MrCertificateMonitoring;
use App\Models\MrNewUsers;
use App\Models\MrUser;
use App\Models\ORM;
use App\Models\References\MrCountry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MrOffice extends ORM
{
  protected $table = 'mr_offices';
  public static $className = MrOffice::class;

  protected $fillable = array(
      'Name',
      'Description',

      'UNP',
      'CountryID',
      'Email',
      'Phone',
    // для свзяи и отправки почты
      'POPostalCode',
      'PORegion',
      'POCity',
      'POAddress',
    // Юр. данные
      'URPostalCode',
      'URRegion',
      'URCity',
      'URAddress',
    // Банковские данные
      'BankRS',
      'BankName',
      'BankCode',
      'BankAddress',
      'PersonSign',
      'PersonPost',
      'PersonFIO',
    //'CreateDate'
  );

  public function after_delete()
  {
  }

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if (!$this->canView())
      return false;

    if ($me->IsSuperAdmin())
    {
      //return true;
    }

    foreach ($this->GetUsers() as $uio)
    {
      $user = $uio->getUser();
      if ($user->id() == $me->id())
      {
        return $uio->getIsAdmin();
      }
    }

    return false;
  }

  public function canView(): bool
  {
    $me = MrUser::me();
    if ($me->IsSuperAdmin())
    {
      //return true;
    }

    foreach ($this->GetUsers() as $uio)
    {
      $user = $uio->getUser();
      if ($user->id() == $me->id())
      {
        return true;
      }
    }

    return false;
  }

  public function canDelete(): bool
  {
    return true;
  }

  public function before_delete()
  {
    foreach ($this->GetUsers() as $userInOffice)
    {
      $userInOffice->mr_delete();
    }
  }

  /**
   * Пользователи ВО
   * @return MrUserInOffice[]
   */
  public function GetUsers(): array
  {
    return MrUserInOffice::LoadArray(['OfficeID' => $this->id()]);
  }


  // Описание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }

  // Наименование офиса
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value): void
  {
    $this->Name = $value;
  }

  // Дата создания офиса
  public function getCreateDate(): MrDateTime
  {
    return MrDateTime::fromValue($this->CreateDate);
  }

  //'UNP'
  public function getUNP(): ?string
  {
    return $this->UNP;
  }

  public function setUNP(?string $value): void
  {
    $this->UNP = $value;
  }

  //'CountryID'
  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(?int $value): void
  {
    $this->CountryID = $value;
  }

  //'Email'
  public function getEmail(): ?string
  {
    return $this->Email;
  }

  public function setEmail(?string $value): void
  {
    $this->Email = $value;
  }

  //'Phone'
  public function getPhone(): ?string
  {
    return $this->Phone;
  }

  public function setPhone(?string $value): void
  {
    $this->Phone = $value;
  }

  //'POPostalCode'
  public function getPOPostalCode(): ?string
  {
    return $this->POPostalCode;
  }

  public function setPOPostalCode(?string $value): void
  {
    $this->POPostalCode = $value;
  }

  //'PORegion'
  public function getPORegion(): ?string
  {
    return $this->PORegion;
  }

  public function setPORegion(?string $value): void
  {
    $this->PORegion = $value;
  }

  //'POCity'
  public function getPOCity(): ?string
  {
    return $this->POCity;
  }

  public function setPOCity(?string $value): void
  {
    $this->POCity = $value;
  }

  //'POAddress'
  public function getPOAddress(): ?string
  {
    return $this->POAddress;
  }

  public function setPOAddress(?string $value): void
  {
    $this->POAddress = $value;
  }

  //'URPostalCode'
  public function getURPostalCode(): ?string
  {
    return $this->URPostalCode;
  }

  public function setURPostalCode(?string $value): void
  {
    $this->URPostalCode = $value;
  }

  //'URRegion'
  public function getURRegion(): ?string
  {
    return $this->URRegion;
  }

  public function setURRegion(?string $value): void
  {
    $this->URRegion = $value;
  }

  //'URCity'
  public function getURCity(): ?string
  {
    return $this->URCity;
  }

  public function setURCity(?string $value): void
  {
    $this->URCity = $value;
  }

  //'URAddress'
  public function getURAddress(): ?string
  {
    return $this->URAddress;
  }

  public function setURAddress(?string $value): void
  {
    $this->URAddress = $value;
  }

  //'BankRS'
  public function getBankRS(): ?string
  {
    return $this->BankRS;
  }

  public function setBankRS(?string $value): void
  {
    $this->BankRS = $value;
  }

  //'BankName'
  public function getBankName(): ?string
  {
    return $this->BankName;
  }

  public function setBankName(?string $value): void
  {
    $this->BankName = $value;
  }

  //'BankCode'
  public function getBankCode(): ?string
  {
    return $this->BankCode;
  }

  public function setBankCode(?string $value): void
  {
    $this->BankCode = $value;
  }

  //'BankAddress'
  public function getBankAddress(): ?string
  {
    return $this->BankAddress;
  }

  public function setBankAddress(?string $value): void
  {
    $this->BankAddress = $value;
  }

  //'PersonSign'
  public function getPersonSign(): ?string
  {
    return $this->PersonSign;
  }

  public function setPersonSign(?string $value): void
  {
    $this->PersonSign = $value;
  }

  //'PersonPost'
  public function getPersonPost(): ?string
  {
    return $this->PersonPost;
  }

  public function setPersonPost(?string $value): void
  {
    $this->PersonPost = $value;
  }

  //'PersonFIO'
  public function getPersonFIO(): ?string
  {
    return $this->PersonFIO;
  }

  public function setPersonFIO(?string $value): void
  {
    $this->PersonFIO = $value;
  }

  ////////////////////////////////////////////////////////////////

  /**
   * Есть ли пользователь в данном ВО
   *
   * @param MrUser $user
   * @return bool
   */
  public function IsUserInOffice(MrUser $user): bool
  {
    foreach ($this->GetUsers() as $item)
    {
      if ($item->getUser()->id() == $user->id())
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Количество администраторов в офисе
   *
   * @return int
   */
  public function countAdmins(): int
  {
    $i = 0;
    foreach ($this->GetUsers() as $uio)
    {
      if ($uio->getIsAdmin())
      {
        $i++;
      }
    }

    return $i;
  }

  /**
   * Список приглашённых, но ещё не добавленных пользователей
   *
   * @return MrNewUsers[]
   */
  public function GetNewUsers(): array
  {
    return MrNewUsers::LoadArray(['OfficeID' => $this->id()]);
  }

  /**
   * Список отслеживаемых сертификатов
   *
   * @return Collection
   */
  public function GetMonitoringCertificates()
  {
    $uio_id = array();
    foreach ($this->GetUsers() as $uio)
    {
      $uio_id[] = $uio->id();
    }

    return DB::table(MrCertificateMonitoring::getTableName())->whereIn('UserInOfficeID', [$uio_id])->get();
  }
}