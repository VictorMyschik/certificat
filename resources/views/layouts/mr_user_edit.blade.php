<form action="{{route('data_user_edit')}}" method="POST">
  {{ Form::token() }}
  <div class="col-lg-5 col-md-6 col-sm-12 justify-content-center align-items-top">
    <table class="col-md-8 col-sm-12">
      <tr>
        <td class="align-content-center mr-border-radius-10" colspan="2"><h5
              class=" mr-bold">
            Личные данные</h5></td>
      </tr>
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
    <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ __('mr-t.Сохранить') }}</button>
    <button type="reset" id="mr-btn" class="mr-sumbit-cancel m-2">{{ __('mr-t.Сбросить') }}</button>
  </div>
  <hr>
</form>