@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-body">
            <h5>{{ __('mr-t.Проверьте свою электронною почту') }}</h5>
            <hr>
            @if (session('resent'))
              <h4>{{ __('mr-t.На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}</h4>
            @endif
            {{ __('mr-t.Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
            {{ __('mr-t.Если вы не получили письмо') }},
            <a href="{{ route('verification.resend') }}">{{ __('mr-t.нажмите здесь, чтобы отправить ещё раз') }}</a>.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
