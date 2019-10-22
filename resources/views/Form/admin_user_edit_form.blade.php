@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/users/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="d-md-flex justify-content-center align-items-top">
      <div class="col-lg-6 col-md-6 col-sm-12 margin-t-20 ">
        <h4>Регистрационные</h4>
        <table class="col-md-8 col-sm-12">
          <tr>
            <td class="mr-right col-sm-6">Login<span class="mr-middle" id="Login"></span></td>
            <td class="mr-right col-sm-6"><label>
                <input type="text" name="Login" value="{{ $user->getName() }}" class="mr-input">
              </label></td>
          </tr>
          <tr>
            <td class="mr-right col-sm-6">Email<span class="mr-middle" id="Email"></span></td>
            <td class="mr-right col-sm-6"><label>
                <input type="email" name="Email" value="{{ $user->getEmail() }}" class="mr-input">
              </label></td>
          </tr>
          <tr>
            <td class="mr-right col-sm-6">Пароль<span class="mr-middle" id="Password"></span></td>
            <td class="mr-right col-sm-6"><label>
                <input type="password" autocomplete="new-password" name="Password" value="" class="mr-input">
              </label></td>
          </tr>
          <tr>
            <td class="mr-right col-sm-6">Повтор пароля<span class="mr-middle" id="password_reset"></span></td>
            <td class="mr-right col-sm-6"><label>
                <input type="password" name="password_reset" value="" class="mr-input">
              </label></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>
@include('Form.BaseForm.footer')