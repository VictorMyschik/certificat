@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/reference/country/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="">
      <label>Наименование<span id="Name"></span>
        <input name="NameRus" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $country->getNameRus() }}">
      </label>
    </div>

    <div class="">
      <label>English<span id="Description"></span>
        <input name="NameEng" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $country->getNameEng() }}">
      </label>
    </div>

    <div class="">
      <label>Код<span id="Description"></span>
        <input name="Code" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $country->getCode() }}">
      </label>
    </div>

		<div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
			<button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
			<button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
		</div>
  </form>
</div>
@include('Form.BaseForm.footer')