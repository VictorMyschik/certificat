@extends('layouts.app')

@section('content')
  @include('Office.mr_nav_user')
  <div class="container col-md-9 col-sm-12">
    <h5 class="margin-t-10"><span class="mr-bold">{{__('mr-t.Виртуальный офис')}}:</span> {{ $office->getName() }}</h5>
    <div class="row padding-0">

      <div class="d-inline col-md-4 border mr-border-radius-5 padding-0">
        <div class="mr-bg-blue mr-border-radius-5">
          <h5 class="margin-l-15">{{ __('mr-t.Финансы') }}
            <a href="#" class="btn btn-info btn-xs mr-color-white">{{ __('mr-t.Изменить') }}</a>
          </h5>
        </div>
        <div class="margin-l-15">
          <h6><span class="mr-bold">Баланс:</span> 100 BYN</h6>
          <h5>{{__('mr-t.Тарифные планы')}}:</h5>

          @if(count($office->GetGlobalDiscountList()))
            <div class="mr-color-green-dark margin-b-15">
              <div>Глобальные скидки:</div>
              @foreach($office->GetGlobalDiscountList() as $global_discount)
                <li>{{$global_discount->GetFullName()}}</li>
              @endforeach
            </div>
          @endif

          @foreach($office->GetTariffs() as $tariff_in_office)
            <li>{{ $tariff_in_office->getTariff()->getName() }}
              @if(count($tariff_in_office->GetDiscountList()))
                <span class="mr-color-green-dark"><i> {{ __('mr-t.Скидка') }}:
                @foreach($tariff_in_office->GetDiscountList() as $discount)
                      <span class="">{{ $discount->GetFullName() }}</span>
                    @endforeach
                </i></span>
              @endif
            </li>
          @endforeach
        </div>
      </div>


    </div>

    <div class="row padding-0 mr-border-radius-5 margin-t-10">

      <div class="d-inline col-md-4 border mr-border-radius-5 padding-0">
        <div class="mr-bg-blue mr-border-radius-5">
          <h5 class="margin-l-15">{{ __('mr-t.Пользователи') }}
            <a href="#" class="btn btn-info btn-xs mr-color-white">{{ __('mr-t.Добавить') }}</a>
          </h5>
        </div>
        <div class="padding-0">
          <table class="table mr-middle padding-0">
            @foreach($office->GetUsers() as $user)
              <tr>
                <td>{{ $user->getUser()->getName() }}</td>
                <td>{{ $user->getUser()->getEmail() }}</td>
                <td>
                  {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_user_edit',
                 'Admin\\MrAdminOfficeUserEditForm', ['id' => $user->id()], '',
                  ['btn', 'btn-info', 'btn-xs','mr-border-radius-5', 'fa fa-edit'])
                 !!}
                </td>
              </tr>
              <tr>
                <td>{{ $user->getUser()->getName() }}</td>
                <td>{{ $user->getUser()->getEmail() }}</td>
                <td>
                  {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_user_edit',
                 'Admin\\MrAdminOfficeUserEditForm', ['id' => $user->id()], '',
                  ['btn', 'btn-info', 'btn-xs', ' fa fa-edit mr-border-radius-15'])
                 !!}
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>

    </div>
  </div>
  <div class="modal fade" id="mr_modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body"></div>
      </div>
    </div>
  </div>
@endsection
