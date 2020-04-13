@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      <h5 class="mr-bold">{{__('mr-t.Личная страница')}}</h5>
      <div>{{ $user->GetFullName() }}</div>
      <hr>
      <div>
        {!! MrBtn::loadForm('user_form_edit', ['id' => $user->id()], '', ['btn-primary btn-sm fa fa-edit'],'xs') !!}  {{__('mr-t.Изменить параметры входа')}}
      </div>
      <div class="margin-t-5">
        {!! MrBtn::loadForm('user_telegram_edit', ['id' => $user->id()], '', ['btn-primary btn-sm fa fa-edit'],'xs') !!}  {{__('mr-t.Telegram оповещение')}}

      </div>
      <div class="margin-t-5">
        @if($user->getIsSubscription())
          <a class="btn btn-danger btn-sm fa fa-trash"
             href="{{ route('toggle_subscription', ['id'=>$user->id()]) }}"></a>
          {{ __('mr-t.Отменить подписку') }}
        @else
          <a class="btn btn-success btn-sm fa fa-edit"
             href="{{ route('toggle_subscription', ['id'=>$user->id()]) }}"></a>
          {{__('mr-t.Подписаться на новости')}}
        @endif
      </div>
      <div class="margin-t-20">
        <a href="{{ route('self_delete') }}" class="mr-color-red"
           onclick="return confirm('Вы уверены? Будет удалён Ваш акаунт вместе со всеми данными! Это действие необратимо!');">
          {{__('mr-t.Удалить акаунт')}}</a>
      </div>
      <div class="mr-middle border-top">
        <div>{{ __('mr-t.Дата регистрации') }}: {{ $user->getDateFirstVisit()->format('d.m.Y') }}</div>
        <div>{{ __('mr-t.Текущий сеанс') }}: {{ $user->getDateLogin()->getShortDateShortTime() }}
          <span class="margin-l-15">IP {{ $user->getLogIdent()->getIp() }}</span>
          <span class="margin-l-15">{{ $user->getLogIdent()->GetFullLocation() }}</span>
        </div>
      </div>
    </div>
  </div>
@endsection

