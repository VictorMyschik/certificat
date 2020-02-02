@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
  <div class="container col-md-9 col-sm-12">
    <div class="d-inline col-md-8 ">
      <div class="">
        {!! MrMessage::GetMessage() !!}
        @foreach($errors->all() as $err)
          <li class="mr-color-red">{{ $err }}</li>
        @endforeach
        <h5 class="mr-bold">{{$office->getName()}}</h5>
        <div class="mr-bold mr-middle margin-b-10"
             style="border-bottom: #0c175b 1px solid">
          <a onclick="mr_popup('{{ route('admin_office_edit',['id'=>$office->id()]) }}'); return false;"><span
                class="mr-color-red-dark">{{__('mr-t.Изменить')}}</span></a>
          {{__('mr-t.Офис создан')}}
          : {{ $office->getCreateDate()->GetShortDateShortTime() }}
          @if($me->IsSuperAdmin()) | {{__('mr-t.Примечание')}}: {{ $office->getDescription() }}@endif()
        </div>

        <div class="row col-md-12 padding-0">
          <div class="d-md-inline-flex col-md-8 mr-middle">
            <div class="">
              <h5 class="mr-bold" style="padding-right: 20px;">
                @if($office->canEdit())
                  {!! MrBtn::loadForm('office_po_details_edit', 'Admin\\MrAdminOfficePostDetailsEditForm', ['id'=> $office->id()], '', ['btn-primary btn-xs fa fa-edit']) !!}
                @endif Контактная информация и <br>лицо с правом подписи
              </h5>
              <div class="margin-b-10">
                <div><span class="mr-bold">Лицо с правом подписи:</span>
                  <div>{{ $office->getPersonPost() }}</div>
                  <div class="">{{ $office->getPersonFIO()?:'-' }}</div>
                  <div title="на оновании">{{ $office->getPersonSign()?' ('.$office->getPersonSign().')':null }}</div>
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
                @if($office->canEdit())
                  {!! MrBtn::loadForm('office_ur_details_edit', 'Admin\\MrAdminOfficeURDetailsEditForm', ['id' => $office->id()], '', ['btn btn-primary btn-xs fa fa-edit']) !!}@endif
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
          </div>

          <div class="d-md-inline col-md-4 mr-middle">
            <h5 class="mr-bold">
              @if($me->IsSuperAdmin())
                {!! MrBtn::loadForm('office_tariffs_edit', 'MrOfficeTariffEditForm', ['id' => $office->id()], 'Добавить', ['btn btn-primary btn-xs'],'xs') !!}
              @endif
              {{__('mr-t.Тарифы')}}</h5>
            <div>{!! $tariffs !!}</div>
            <h5 class="mr-bold">{{__('mr-t.Скидки')}}</h5>
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
        <hr>
        <div class="row col-md-12 padding-0 margin-t-20">
          <div class="d-md-inline col-md-4 mr-middle">
            <h5 class="mr-bold">{{__('mr-t.Личные настройки')}}</h5>
            <div>{!! MrBtn::loadForm('user_form_edit', 'MrUserEditForm', ['id' => $me->id()], '', ['btn-primary btn-xs fa fa-edit'],'xs') !!}
              {{ $me->GetFullName() }}
            </div>
            <div class="margin-t-5">
              @if($me->getIsSubscription())
                <a class="btn btn-danger btn-xs fa fa-trash"
                   href="{{ route('toggle_subscription', ['id'=>$me->id()]) }}"></a>
                {{ __('mr-t.Отменить подписку') }}
              @else
                <a class="btn btn-success btn-xs fa fa-edit"
                   href="{{ route('toggle_subscription', ['id'=>$me->id()]) }}"></a>
                {{__('mr-t.Подписаться на новости')}}
              @endif
            </div>

            <div class="margin-t-20">
              <a href="{{ route('self_delete') }}" class="mr-color-red"
                 onclick="return confirm('Вы уверены? Будет удалён Ваш акаунт вместе со всеми данными! Это действие необратимо!');">
                {{__('mr-t.Удалить акаунт')}}</a>
            </div>

          </div>
          <div class="d-md-inline col-md-8 mr-middle">
            <h5 class="mr-bold">{{__('mr-t.Пользователи')}}
              @if($office->canEdit())
                <span title="{{ __('mr-t.Добавить нового пользователя') }}">
                {!! MrBtn::loadForm('add_office_user_edit', 'MrAddOfficeUserForm', ['office_id'=>$office->id(),'id' => $office->id()], __('mr-t.Добавить'), ['btn-primary btn-xs'],'sm') !!}
                </span>
              @endif
            </h5>
            {!! $user_in_office !!}
          </div>
        </div>
      </div>

      <div class="mr-middle border-top">
        <div>{{ __('mr-t.Дата регистрации') }}: {{ $me->getDateFirstVisit()->format('d.m.Y') }}</div>
        <div>{{ __('mr-t.Последний визит') }}: {{ $me->getDateLogin()->format('d.m.Y') }}</div>
      </div>
    </div>
  </div>
@endsection
