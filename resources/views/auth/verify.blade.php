@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-body">
          <h5>{{ __('Проверьте свою электронною почту') }}</h5>
          <hr>
          @if (session('resent'))
            <h4>{{ __('На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}</h4>
          @endif
          {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
          {{ __('Если вы не получили письмо') }},
          <a href="{{ route('verification.resend') }}">{{ __('нажмите здесь, чтобы отправить ещё раз') }}</a>.
        </div>
      </div>
    </div>
  </div>
@endsection
