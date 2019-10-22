@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/panel/delete/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="save_results"></div>
    <label class="mr-bold">
      <input type="checkbox" checked="checked" value="1" name="save_results" class="margin-r-10">
      <input type="hidden" value="3" name="qwe">
      Сохранить мои результаты.
    </label>
    <p class="mr-middle text-justify">В истории соревнований останутся опубликованными Ваши результаты и ФИО участника.
      Другие данные будут удалены.
    </p>
    <p class="mr-middle text-justify">
      При НЕ сохранении, в результатах соревнований будет указано "участник был удалён"
    </p>

    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>
@include('Form.BaseForm.footer')