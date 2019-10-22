@extends('layouts.app')

@section('content')

  <div class="container col-md-9 col-sm-12">

    <h3>{{ __('mr-t.Персональные данные') }}</h3>
    <hr>

    <div class="row col-md-12">
      <div class="d-inline-flex ">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        @foreach($errors->all() as $err)
          <li class="mr-color-red">{{ $err }}</li>
        @endforeach

        <form action="/panel/edit/{{ $user->id() }}" method="POST">
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
                    class="mr-sumbit-success m-2">{{ __('mr-t.Сохранить') }}</button>
            <button type="reset" id="mr-btn" class="mr-sumbit-cancel m-2">{{ __('mr-t.Сбросить') }}</button>
          </div>
          <hr>
        </form>
      </div>

      <div class="">
        <p>Дата регистрации: {{ $user->getDateFirstVisit()->format('d.m.Y') }}</p>
        <p>Последний визит: {{ $user->getDateLogin()->format('d.m.Y') }}</p>
        {!!  \App\Http\Controllers\Forms\MrForm::loadForm('user_delete', 'MrUserDeleteForm', [], 'удалить акаунт',['mr-sumbit-cancel']) !!}
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
