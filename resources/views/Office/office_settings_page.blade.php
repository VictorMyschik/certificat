@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container col-md-11 col-sm-12">
      <div class="d-inline col-md-8 ">
        <div class="">
          {!! MrMessage::GetMessage() !!}
          <h5 class="mr-bold">{{$office->getName()}}</h5>
          <div class="mr-bold mr-middle margin-b-10" style="border-bottom: #0c175b 1px solid">
            <a onclick="mr_popup('{{ route('office_edit') }}'); return false;">
              <span class="mr-color-red-dark">{{__('mr-t.Изменить')}}</span></a>
            {{__('mr-t.Офис создан')}}
            : {{ $office->getCreateDate()->GetShortDateShortTime() }}
            @if($me->IsSuperAdmin())
              | {{__('mr-t.Примечание')}}: <span style="font-weight: normal">{{ $office->getDescription() }}</span>
            @endif()
          </div>

          <div class="row col-md-12 p-0">
            <div class="d-md-inline-flex col-md-8 mr-middle">
              <div class="">
                <h5 class="mr-bold" style="padding-right: 20px;">
                  @if($office->canEdit())
                    {!! MrBtn::loadForm('office_po_details_edit', [], '', ['btn-primary btn-sm fa fa-edit']) !!}
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
                    <td>{{ $office->getCountry() ? $office->getCountry()->getCodeWithName() : null }}</td>
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
                    {!! MrBtn::loadForm('office_ur_details_edit',[], '', ['btn btn-primary btn-sm fa fa-edit']) !!}@endif
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
            </div> <!--тарифы и скидки-->
          </div>
          <hr>
          <div class="row col-md-12 p-0 m-t-20">
            <div class="d-md-inline col-md-4 mr-middle">
              <h5 class="mr-bold">{{__('mr-t.Личные настройки')}}</h5>
              <div>{!! MrLink::open('personal_page', [],'', 'btn-primary btn-sm fa fa-eye') !!}
                {{ $me->GetFullName() }}
              </div>
            </div>
            <div class="d-md-inline col-md-8 mr-middle">
              <h5 class="mr-bold">{{__('mr-t.Пользователи виртуального офиса')}}
                @if($office->canEdit())
                  <span title="{{ __('mr-t.Добавить нового пользователя') }}">
                {!! MrBtn::loadForm('add_office_user_edit', ['office_id'=>$office->id(),'id' => $office->id()], __('mr-t.Добавить'), ['btn-primary btn-sm'],'sm') !!}
                </span>
                @endif
              </h5>
              @if(count($office->GetNewUsers()))
                @include('layouts.Elements.table',['data'=>$new_table])
              @endif
              @include('layouts.Elements.table',['data'=>$uio_table])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
