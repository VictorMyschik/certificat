<?php


namespace App\Http\Models;


use App\Http\Controllers\Helpers\MtDateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MrOffice extends ORM
{
  public static $mr_table = 'mr_offices';
  public static $className = MrOffice::class;

  protected static $dbFieldsMap = array(
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

  public static function loadBy($value, $field = 'id'): ?MrOffice
  {
    return parent::loadBy((string)$value, $field);
  }

  public function canEdit(): bool
  {
    $me = MrUser::me();
    if($me->IsSuperAdmin())
    {
      return true;
    }

    foreach ($this->GetUsers() as $uio)
    {
      $user = $uio->getUser();
      if($user->id() == $me->id())
      {
        return $uio->getIsAdmin();
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
    foreach ($this->GetTariffs() as $tariffInOffice)
    {
      $tariffInOffice->mr_delete();
    }

    foreach ($this->GetUsers() as $userInOffice)
    {
      $userInOffice->mr_delete();
    }
  }

  /**
   * @return MrTariffInOffice[]
   */
  public function GetTariffs(): array
  {
    $list = DB::table(MrTariffInOffice::$mr_table)->where('OfficeID', $this->id())->get();
    return parent::LoadArray($list, MrTariffInOffice::class);
  }


  /**
   * @return MrUserInOffice[]
   */
  public function GetUsers(): array
  {
    $list = DB::table(MrUserInOffice::$mr_table)->where('OfficeID', $this->id())->get();
    return parent::LoadArray($list, MrUserInOffice::class);
  }


  // Описание для себя
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value)
  {
    $this->Description = $value;
  }

  // Наименование офиса
  public function getName(): string
  {
    return $this->Name;
  }

  public function setName(string $value)
  {
    $this->Name = $value;
  }

  // Дата создания офиса
  public function getCreateDate(): MtDateTime
  {
    return MtDateTime::fromValue($this->CreateDate);
  }

  //'UNP'
  public function getUNP(): ?string
  {
    return $this->UNP;
  }

  public function setUNP(?string $value)
  {
    $this->UNP = $value;
  }

  //'CountryID'
  public function getCountry(): ?MrCountry
  {
    return MrCountry::loadBy($this->CountryID);
  }

  public function setCountryID(int $value)
  {
    $this->CountryID = $value;
  }

  //'Email'
  public function getEmail(): ?string
  {
    return $this->Email;
  }

  public function setEmail(?string $value)
  {
    $this->Email = $value;
  }

  //'Phone'
  public function getPhone(): ?string
  {
    return $this->Phone;
  }

  public function setPhone(?string $value)
  {
    $this->Phone = $value;
  }

  //'POPostalCode'
  public function getPOPostalCode(): ?string
  {
    return $this->POPostalCode;
  }

  public function setPOPostalCode(?string $value)
  {
    $this->POPostalCode = $value;
  }

  //'PORegion'
  public function getPORegion(): ?string
  {
    return $this->PORegion;
  }

  public function setPORegion(?string $value)
  {
    $this->PORegion = $value;
  }

  //'POCity'
  public function getPOCity(): ?string
  {
    return $this->POCity;
  }

  public function setPOCity(?string $value)
  {
    $this->POCity = $value;
  }

  //'POAddress'
  public function getPOAddress(): ?string
  {
    return $this->POAddress;
  }

  public function setPOAddress(?string $value)
  {
    $this->POAddress = $value;
  }

  //'URPostalCode'
  public function getURPostalCode(): ?string
  {
    return $this->URPostalCode;
  }

  public function setURPostalCode(?string $value)
  {
    $this->URPostalCode = $value;
  }

  //'URRegion'
  public function getURRegion(): ?string
  {
    return $this->URRegion;
  }

  public function setURRegion(?string $value)
  {
    $this->URRegion = $value;
  }

  //'URCity'
  public function getURCity(): ?string
  {
    return $this->URCity;
  }

  public function setURCity(?string $value)
  {
    $this->URCity = $value;
  }

  //'URAddress'
  public function getURAddress(): ?string
  {
    return $this->URAddress;
  }

  public function setURAddress(?string $value)
  {
    $this->URAddress = $value;
  }

  //'BankRS'
  public function getBankRS(): ?string
  {
    return $this->BankRS;
  }

  public function setBankRS(?string $value)
  {
    $this->BankRS = $value;
  }

  //'BankName'
  public function getBankName(): ?string
  {
    return $this->BankName;
  }

  public function setBankName(?string $value)
  {
    $this->BankName = $value;
  }

  //'BankCode'
  public function getBankCode(): ?string
  {
    return $this->BankCode;
  }

  public function setBankCode(?string $value)
  {
    $this->BankCode = $value;
  }

  //'BankAddress'
  public function getBankAddress(): ?string
  {
    return $this->BankAddress;
  }

  public function setBankAddress(?string $value)
  {
    $this->BankAddress = $value;
  }

  //'PersonSign'
  public function getPersonSign(): ?string
  {
    return $this->PersonSign;
  }

  public function setPersonSign(?string $value)
  {
    $this->PersonSign = $value;
  }

  //'PersonPost'
  public function getPersonPost(): ?string
  {
    return $this->PersonPost;
  }

  public function setPersonPost(?string $value)
  {
    $this->PersonPost = $value;
  }

  //'PersonFIO'
  public function getPersonFIO(): ?string
  {
    return $this->PersonFIO;
  }

  public function setPersonFIO(?string $value)
  {
    $this->PersonFIO = $value;
  }

  ////////////////////////////////////////////////////////////////

  /**
   * Скидки ВО
   * @return MrDiscount[]
   */
  public function GetDiscount(): array
  {
    return Cache::rememberForever('discount_' . $this->id(), function () {
      $list = DB::table(MrDiscount::$mr_table)->where('OfficeID', '=', $this->id())->get();
      return parent::LoadArray($list, MrDiscount::class);
    });
  }

  /**
   * @return MrDiscount[]
   */
  public function GetGlobalDiscountList(): array
  {
    $out = array();

    foreach ($this->GetDiscount() as $discount)
    {
      if(!$discount->getTariff())
      {
        $out[] = $discount;
      }
    }

    return $out;
  }

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
      if($item->getUser()->id() == $user->id())
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
      if($uio->getIsAdmin())
      {
        $i++;
      }
    }

    return $i;
  }
}