@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="">
          <div class="card-body">
            <h5> {{ __('mr-t.Регистрация') }}</h5>
            <hr>
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('mr-t.Логин') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                         value="{{ old('name') }}" required autocomplete="name" autofocus>

                  @error('name')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('mr-t.Email') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                         value="{{ old('email') }}" required autocomplete="email">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('mr-t.Пароль') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                         name="password" required autocomplete="new-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm"
                       class="col-md-4 col-form-label text-md-right">{{ __('mr-t.Повтор пароля') }}</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                         required autocomplete="new-password">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">
                  <input required type="checkbox" name="policy">
                </label>

                <div class="col-md-6">
                  {{ __('mr-t.Я согласен с') }} <a href="/policy"
                                                   target="_blank">{{ __('mr-t.Политикой приватности') }}</a>,
                  {{ __('mr-t.а также даю согласие на обработку персональных данных') }}
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-sm btn-primary">
                    {{ __('Register') }}
                  </button>
                </div>
              </div>
              <hr>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
