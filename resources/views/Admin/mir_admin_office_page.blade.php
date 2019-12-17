@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="mr-bold mr-middle margin-b-10"
         style="border-bottom: #0c175b 1px solid">Офис создан: {{ $office->getCreateDate() }} |
      Примечание: {{ $office->getDescription() }}</div>
    {!!  MrMessage::GetMessage() !!}

    <div class="row padding-0">
      <div class="d-inline-flex col-md-8 padding-0 mr-middle">
        <div class="">
          <h5 class="mr-bold">
            {!! MrBtn::loadForm('office_po_details_edit', 'Admin\\MrAdminOfficePostDetailsEditForm', ['id' => $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
            Контактная информация и лицо с правом подписи
          </h5>

          <div class="d-sm-inline padding-horizontal margin-b-10">
            <div><span class="mr-bold">Лицо:</span>
              <span>{{ $office->getPersonPost() }}</span>
              <span class="margin-l-10">{{ $office->getPersonFIO()?:'-' }}</span>
              <span title="на оновании">{{ $office->getPersonSign()?' ('.$office->getPersonSign().')':null }}</span>
            </div>
          </div>
          <div class="d-sm-inline padding-horizontal">
            <div>
              <span class="mr-bold">Страна:</span>
              <span>{{ $office->getCountry() ? $office->getCountry()->getCode() . ' ' . $office->getCountry()->getNameRus():null }}</span>
            </div>
            <div>
              <span class="mr-bold">Регион:</span>
              <span>{{ $office->getPORegion() }}</span>
            </div>
            <div>
              <span class="mr-bold">Город:</span>
              <span>{{ $office->getPOCity() }}</span>
            </div>
            <div>
              <span class="mr-bold">Адрес:</span>
              <span>{{ $office->getPOAddress() }}</span>
            </div>
          </div>
          <div class="d-sm-inline padding-horizontal">
            <div>
              <span class="mr-bold">Email:</span>
              <span>{{ $office->getEmail() }}</span>
            </div>
            <div>
              <span class="mr-bold">Телефон:</span>
              <span>{{ $office->getPhone() }}</span>
            </div>
            <div>
              <span class="mr-bold">Почтовый индекс:</span>
              <span>{{ $office->getPOPostalCode() }}</span>
            </div>
            <div>
              <span class="mr-bold">УНП:</span>
              <span>{{ $office->getUNP() }}</span>
            </div>
          </div>
        </div>

        <div class="mr-middle padding-0">
          <h5 class="mr-bold margin-b-5">
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_ur_details_edit', 'Admin\\MrAdminOfficeURDetailsEditForm', ['id' => $office->id()], '', ['btn btn-primary btn-xs fa fa-edit']) !!}
            Юридическая информация
          </h5>
          <div class="d-sm-inline padding-horizontal">
            <div>
              <span class="mr-bold">Почтовый индекс:</span>
              <span>{{ $office->getURPostalCode() }}</span>
            </div>
            <div>
              <span class="mr-bold">Регион:</span>
              <span>{{ $office->getURRegion() }}</span>
            </div>
            <div>
              <span class="mr-bold">Город:</span>
              <span>{{ $office->getURCity() }}</span>
            </div>
            <div>
              <span class="mr-bold">ЮР Адрес:</span>
              <span>{{ $office->getURAddress() }}</span>
            </div>
          </div>

          <div class="d-sm-inline padding-horizontal">
            <div>
              <span class="mr-bold">Банк р/с:</span>
              <td>{{ $office->getBankRS() }}</td>
            </div>
            <div>
              <span class="mr-bold">Имя банка:</span>
              <span>{{ $office->getBankName() }}</span>
            </div>
            <div>
              <span class="mr-bold">Код банка:</span>
              <span>{{ $office->getBankCode() }}</span>
            </div>
            <div>
              <span class="mr-bold">Адрес банка:</span>
              <span>{{ $office->getBankAddress() }}</span>
            </div>
          </div>
        </div>

      </div>
      <div class="d-inline col-md-4 col-sm-12">
        <div class="">
          <h4 class="mr-bold">
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_tariffs_edit', 'Admin\\MrAdminOfficeTariffEditForm', ['id' => $office->id()], 'Добавить', ['btn btn-primary btn-xs']) !!}
            Тарифы</h4>
          <table id="" class="table table-striped table-bordered mr-middle">
            <thead>
            <tr>
              <td>Тариф</td>
              <td>Добавлен</td>
              <td>#</td>
            </tr>
            </thead>
            <tbody>
            @foreach($office->GetTariffs() as $tariff)
              <tr>
                <td class="padding-horizontal">{{ $tariff->getTariff()->getName() }}</td>
                <td class="padding-horizontal">{{ $tariff->getCreateDate()->getShortDate() }}</td>
                <td>
                  <a href="{{ route('tariff_office_delete',['id'=>$tariff->id()]) }}"
                     class="btn btn-danger btn-xs mr-border-radius-5"
                     onclick="return confirm('Уверены?');"><i class="fa fa-trash"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <h4 class="mr-bold">
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_discount_edit', 'Admin\\MrAdminOfficeDiscountEditForm', ['id' => '0', 'office_id' => $office->id()], 'Добавить', ['btn btn-primary btn-xs']) !!}
            Скидки</h4>
          <table class="table table-striped table-bordered mr-middle">
            <thead>
            <tr>
              <td>Тариф</td>
              <td>Дата с</td>
              <td>Дата по</td>
              <td>Размер</td>
              <td>#</td>
            </tr>
            <thead>
            <tbody>
            @foreach($office->GetDiscount() as $discount)
              <tr>
                <td>{{ $discount->getTariff()?$discount->getTariff()->getName():'Global' }}</td>
                <td>{{ $discount->getDateFrom()->getShortDate() }}</td>
                <td>{{ $discount->getDateTo()->getShortDate() }}</td>
                <td>{!! $discount->getAmount().'<div>('.$discount->getKindName().')</div>' !!}</td>
                <td>
                  {!! MrBtn::loadForm('office_discount_edit', 'Admin\\MrAdminOfficeDiscountEditForm', ['id' => $discount->id(), 'office_id' => $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
                  <a href="{{ route('discount_delete',['id'=>$discount->id()]) }}"
                     class="btn btn-danger btn-xs mr-border-radius-5"
                     onclick="return confirm('Уверены?');"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="d-inline col-md-9 ">
      <hr>
        <h4 class="mr-bold">Пользователи
          {!! MrBtn::loadForm('office_user_edit', 'Admin\\MrAdminOfficeUserEditForm', ['id' => $office->id()], 'Добавить пользователя', ['btn-primary btn-xs']) !!}
        </h4>
        <table class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>ФИО</td>
            <td>Почта</td>
            <td>Admin</td>
            <td>#</td>
          </tr>
          </thead>
          <tbody>
          @foreach($office->GetUsers() as $user_in_office)
            <tr>
              <td class="padding-horizontal">{{ $user_in_office->getUser()->getName() }}</td>
              <td class="padding-horizontal">{{ $user_in_office->getUser()->getEmail() }}</td>
              <td class="padding-horizontal"><a
                    href="{{  route('user_office_toggle_admin',['id'=>$user_in_office->id()]) }}"
                    class="btn {{ $user_in_office->getIsAdmin() ?'btn-success':'btn-danger' }} btn-xs mr-border-radius-5">{!! $user_in_office->getIsAdmin()?'<span title="Выключить">Администратор <i class="fa fa-check"></i></span>':'<span title="Выключить">Пользователь <i title="Включить" class="fa fa-check"></i></span>'!!}

                </a>
              </td>
              <td>
                <a href="{{ route('user_office_delete',['id'=>$user_in_office->id()]) }}"
                   class="btn btn-danger btn-xs mr-border-radius-5"
                   onclick="return confirm('Уверены?');"><i class="fa fa-trash-alt"></i></a></td>
            </tr>
          @endforeach
          </tbody>
        </table>
    </div>


    <div class="d-inline-flex col-md-9 ">
      <hr>
      <h4 class="mr-bold">Статистика</h4>
    </div>
  </div>
@endsection
