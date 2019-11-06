@extends('layouts.app')

@section('content')
  @include('Office.mr_nav_user')
  <div class="container col-md-9 col-sm-12">
    <h4 class="margin-t-10"><span class="mr-bold">{{__('mr-t.Виртуальный офис')}}:</span> {{ $office->getName() }}</h4>
    <div class="row padding-0">

      <div class="d-inline col-md-4 border mr-border-radius-10 padding-0">
        <div class="mr-bg-blue mr-border-radius-10">
          <h3 class="margin-l-15">{{ __('mr-t.Финансы') }} <a href="#" class="btn btn-info btn-xs mr-color-white">{{ __('mr-t.Изменить') }}</a></h3>
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


      <div class="d-inline col-md-8 ">
        <div class="">
          {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
          @foreach($errors->all() as $err)
            <li class="mr-color-red">{{ $err }}</li>
          @endforeach

          <form action="/office/edit/{{ $user->id() }}" method="POST">
            {{ Form::token() }}
            <div class="col-lg-5 col-md-6 col-sm-12 justify-content-center align-items-top">
              <table class="col-md-8 col-sm-12">
                <tr>
                  <td class="mr-right col-sm-6">Login</td>
                  <td class="mr-right col-sm-6"><label>
                      <input type="text" name="name" value="{{ $user->getName() }}" class="mr-input">
                    </label></td>
                </tr>
                <tr>
                  <td class="mr-right col-sm-6">Email</td>
                  <td class="mr-right col-sm-6"><label>
                      <input type="email" name="Email" value="{{ $user->getEmail() }}" class="mr-input">
                    </label></td>
                </tr>
                <tr>
                  <td class="mr-right col-sm-6">{{ __('mr-t.Пароль') }}</td>
                  <td class="mr-right col-sm-6"><label>
                      <input type="password" autocomplete="new-password" name="Password" value="" class="mr-input">
                    </label></td>
                </tr>
                <tr>
                  <td class="mr-right col-sm-6">{{ __('mr-t.Повтор пароля') }}</td>
                  <td class="mr-right col-sm-6"><label>
                      <input type="password" autocomplete="new-password" name="password_reset" value=""
                             class="mr-input">
                    </label></td>
                </tr>
              </table>
            </div>

            <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
              <button type="submit" id="mr-btn"
                      class="mr-sumbit-success m-2">{{ __('mr-t.Сохранить') }}
              </button>
              <button type="reset" id="mr-btn" class="mr-sumbit-cancel m-2">{{ __('mr-t.Сбросить') }}</button>
            </div>
            <hr>
          </form>
        </div>

        <div class="">
          <div>{{ __('mr-t.Дата регистрации') }}: {{ $user->getDateFirstVisit()->format('d.m.Y') }}</div>
          <div>{{ __('mr-t.Последний визит') }}: {{ $user->getDateLogin()->format('d.m.Y') }}</div>
        </div>
      </div>

    </div>

    <div class="row padding-0 mr-border-radius-10 margin-t-10">

      <div class="d-inline col-md-4 border mr-border-radius-10 padding-0">
        <div class="mr-bg-blue mr-border-radius-10">
          <h3 class="margin-l-15">{{ __('mr-t.Пользователи') }} <a href="#" class="btn btn-info btn-xs mr-color-white">{{ __('mr-t.Добавить') }}</a></h3>
        </div>
        <div class="margin-l-15">
          @foreach($office->GetUsers() as $user)
            <li>{{ $user->getUser()->GetFullName() }}</li>
          @endforeach
        </div>
      </div>


    </div>
  </div>


  <div class="modal fade" id="mr_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body"></div>
      </div>
    </div>
  </div>
@endsection
