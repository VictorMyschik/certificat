@extends('layouts.app')

@section('content')
  @include('Office.mr_nav_user')
  <div class="container col-md-9 col-sm-12">
    <div class="d-inline col-md-8 ">
      <div class="">
        {!! MrMessage::GetMessage() !!}
        @foreach($errors->all() as $err)
          <li class="mr-color-red">{{ $err }}</li>
        @endforeach

        <div class="mr-bold mr-middle margin-b-10"
             style="border-bottom: #0c175b 1px solid">Офис создан: {{ $office->getCreateDate()->GetShortDateShortTime() }}
         @if($user->IsAdmin()) | Примечание: {{ $office->getDescription() }}@endif()
        </div>

        <div class="row col-md-12 padding-0">
          <div class="d-md-inline-flex col-md-8 mr-middle">
            <div class="">
              <h5 class="mr-bold" style="padding-right: 20px;">
                {!! MrBtn::loadForm('office_po_details_edit', 'Admin\\MrAdminOfficePostDetailsEditForm', ['id' => $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
                Контактная информация и лицо с правом подписи
              </h5>
              <div class="margin-b-10">
                <div><span class="mr-bold">Лицо:</span>
                  <span>{{ $office->getPersonPost() }}</span>
                  <span class="margin-l-10">{{ $office->getPersonFIO()?:'-' }}</span>
                  <span title="на оновании">{{ $office->getPersonSign()?' ('.$office->getPersonSign().')':null }}</span>
                </div>
              </div>
              <table class="margin-b-10 col-md-12">
                <tr>
                  <td class="mr-bold">Страна:</td>
                  <td>{{ $office->getCountry() ? $office->getCountry()->getCode() . ' ' . $office->getCountry()->getNameRus():null }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Регион:</td>
                  <td>{{ $office->getPORegion() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Город:</td>
                  <td>{{ $office->getPOCity() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Адрес:</td>
                  <td>{{ $office->getPOAddress() }}</td>
                </tr>
                <tr>
                  <td colspan="2"><br></td>
                </tr>
                <tr>
                  <td class="mr-bold">Email:</td>
                  <td>{{ $office->getEmail() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Телефон:</td>
                  <td>{{ $office->getPhone() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Почтовый индекс:</td>
                  <td>{{ $office->getPOPostalCode() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">УНП:</td>
                  <td>{{ $office->getUNP() }}</td>
                </tr>
              </table>
            </div>
            <div class="">
              <h5 class="mr-bold margin-b-5">
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_ur_details_edit', 'Admin\\MrAdminOfficeURDetailsEditForm', ['id' => $office->id()], '', ['btn btn-primary btn-xs fa fa-edit']) !!}
                Юридическая информация
              </h5>
              <table class="margin-b-10">
                <tr>
                  <td class="mr-bold">Почтовый индекс:</td>
                  <td>{{ $office->getURPostalCode() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Регион:</td>
                  <td>{{ $office->getURRegion() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Город:</td>
                  <td>{{ $office->getURCity() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">ЮР Адрес:</td>
                  <td>{{ $office->getURAddress() }}</td>
                </tr>
                <tr>
                  <td colspan="2"><br></td>
                </tr>
                <tr>
                  <td class="mr-bold">Банк р/с:</td>
                  <td>{{ $office->getBankRS() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Имя банка:</td>
                  <td>{{ $office->getBankName() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Код банка:</td>
                  <td>{{ $office->getBankCode() }}</td>
                </tr>
                <tr>
                  <td class="mr-bold">Адрес банка:</td>
                  <td>{{ $office->getBankAddress() }}</td>
                </tr>
              </table>
            </div>
          </div><!--данные по ВО-->

          <div class="d-md-inline col-md-4 mr-middle">
            <h5 class="mr-bold">Тарифы</h5>
            <div>
              <table class="table table-striped table-bordered mr-middle">
                <thead class="mr-bold">
                <tr>
                  <td>Тариф</td>
                  <td>Добавлен</td>
                </tr>
                </thead>
                <tbody>
                @foreach($office->GetTariffs() as $tariff)
                  <tr>
                    <td class="padding-horizontal">{{ $tariff->getTariff()->getName() }}</td>
                    <td class="padding-horizontal">{{ $tariff->getCreateDate()->getShortDate() }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <h5 class="mr-bold">Скидки</h5>
            <div>
              <table class="table table-striped table-bordered mr-middle">
                <thead class="mr-bold">
                <tr>
                  <td>Тариф</td>
                  <td>Дата с</td>
                  <td>Дата по</td>
                  <td>Размер</td>
                </tr>
                <thead>
                <tbody>
                @foreach($office->GetDiscount() as $discount)
                  <tr>
                    <td>{{ $discount->getTariff()?$discount->getTariff()->getName():'Global' }}</td>
                    <td>{{ $discount->getDateFrom()->getShortDate() }}</td>
                    <td>{{ $discount->getDateTo()->getShortDate() }}</td>
                    <td>{!! $discount->getAmount().'<div>('.$discount->getKindName().')</div>' !!}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div> <!--тарифы и скидки-->
        </div>

        <div class="row col-md-12 padding-0 margin-t-20">
          <div class="d-md-inline col-md-4 mr-middle">
            <h5 class="mr-bold">Личные настройки</h5>
            <div>{!! MrBtn::loadForm('office_ur_details_edit', 'MrAddOfficeUserForm', ['id' => $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
              {{ $user->GetFullName() }}
            </div>
            <div class="margin-t-5">{!! MrBtn::loadForm('office_user_edit', 'MrAddOfficeUserForm', ['id' => $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
              Подписка на новости
            </div>

            <div class="margin-t-20">
              <a href="" class="mr-color-red" onclick="return confirm('Вы уверены? Будет удалён Ваш акаунт вместе со всеми данными! Это действие необратимо!');">Удалить акаунт</a>
            </div>

          </div>
          <div class="d-md-inline col-md-8 mr-middle">
            <h5 class="mr-bold">Пользователи
              {!! MrBtn::loadForm('office_user_edit', 'MrAddOfficeUserForm', ['id' => $office->id()], 'Добавить', ['btn-primary btn-xs'],'sm') !!}
            </h5>
            <table class="table table-striped table-bordered mr-middle">
              <thead>
              <tr>
                <td>ФИО</td>
                <td>Почта</td>
                <td>Admin</td>
                @if($user->IsAdmin())<td>#</td>@endif
              </tr>
              </thead>
              <tbody>
              @foreach($office->GetUsers() as $user_in_office)
                <tr>
                  <td class="padding-horizontal">{{ $user_in_office->getUser()->getName() }}</td>
                  <td class="padding-horizontal">{{ $user_in_office->getUser()->getEmail() }}</td>
                  <td class="padding-horizontal"><a
                        href="{{  route('user_office_toggle_admin',['id'=>$user_in_office->id()]) }}"
                        class="btn {{ $user_in_office->getIsAdmin() ?'btn-success':'btn-secondary' }} btn-xs mr-border-radius-5">{!! $user_in_office->getIsAdmin()?'<span title="Выключить">Администратор <i class="fa fa-check"></i></span>':'<span title="Выключить">Пользователь</span>'!!}

                    </a>
                  </td>
                  @if($user->IsAdmin())<td>
                    <a href="{{ route('user_office_delete',['id'=>$user_in_office->id()]) }}"
                       class="btn btn-danger btn-xs mr-border-radius-5"
                       onclick="return confirm('Уверены?');"><i class="fa fa-trash-alt"></i></a></td>@endif
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="mr-middle border-top">
        <div>{{ __('mr-t.Дата регистрации') }}: {{ $user->getDateFirstVisit()->format('d.m.Y') }}</div>
        <div>{{ __('mr-t.Последний визит') }}: {{ $user->getDateLogin()->format('d.m.Y') }}</div>
      </div>
    </div>
  </div>
@endsection
